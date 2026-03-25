<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PDO;
use Throwable;

class EleventaSync extends Command
{
    protected $signature = 'eleventa:sync
                            {--dry-run : Show what would be synced without making changes}';

    protected $description = 'Sync products, categories and brands from Eleventa POS (Firebird DB)';

    private string $fbDatabase;
    private string $fbUser;
    private string $fbPassword;

    private array $skipDeptIds = [2]; // "Productos Comunes"
    private array $skipDeptNames = ['Eliminado']; // partial match to skip deleted depts

    private PDO $firebird;
    private bool $dryRun = false;

    public function handle(): int
    {
        $this->dryRun = $this->option('dry-run');
        $this->fbDatabase = env('ELEVENTA_DB_PATH', base_path('eleventa/pdvdata.fdb'));
        $this->fbUser = env('ELEVENTA_DB_USER', 'SYSDBA');
        $this->fbPassword = env('ELEVENTA_DB_PASSWORD', '');

        if ($this->dryRun) {
            $this->warn('--- DRY RUN: no changes will be saved ---');
        }

        if (!file_exists($this->fbDatabase)) {
            $this->error("Firebird DB not found: {$this->fbDatabase}");
            $this->error("Place the pdvdata.fdb file there and try again.");
            return self::FAILURE;
        }

        $this->info('Connecting to Eleventa Firebird DB...');

        try {
            $dsn = "firebird:dbname=localhost/3050:{$this->fbDatabase};charset=WIN1252";
            $this->firebird = new PDO($dsn, $this->fbUser, $this->fbPassword);
            $this->firebird->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->info('Connected.');
        } catch (Throwable $e) {
            $this->error('Connection failed: ' . $e->getMessage());
            return self::FAILURE;
        }

        $this->syncCategories();
        $this->syncBrands();
        $this->syncProducts();

        $this->cleanupOrphans();

        $this->newLine();
        $this->info('Sync completed.');
        return self::SUCCESS;
    }

    // ── Categories ← DEPARTAMENTOS ──────────────────────────────────────────

    private function syncCategories(): void
    {
        $this->info('Syncing categories...');

        $rows = $this->firebird
            ->query("SELECT ID, TRIM(NOMBRE) AS NOMBRE, ACTIVO FROM DEPARTAMENTOS ORDER BY ID")
            ->fetchAll(PDO::FETCH_OBJ);

        // Load existing slugs in one query
        $existingSlugs = DB::table('categories')
            ->whereNotNull('eleventa_id')
            ->pluck('slug', 'eleventa_id')
            ->toArray();

        $allCategorySlugs = DB::table('categories')->pluck('slug')->flip()->toArray();

        $synced = 0;
        $toInsert = [];
        $toUpdate = [];

        foreach ($rows as $dept) {
            if (in_array((int)$dept->ID, $this->skipDeptIds)) {
                continue;
            }

            $name = $this->utf8($dept->NOMBRE);
            if ($name === '') {
                continue;
            }

            $isActive = trim($dept->ACTIVO ?? '') === '1' ? 1 : 0;
            if (!$isActive) {
                continue;
            }

            foreach ($this->skipDeptNames as $skip) {
                if (stripos($name, $skip) !== false) {
                    continue 2;
                }
            }

            $eleventaId = (int)$dept->ID;

            if ($this->dryRun) {
                $this->line("  [cat] id={$eleventaId} name={$name} active={$isActive}");
                $synced++;
                continue;
            }

            $slug = $existingSlugs[$eleventaId] ?? $this->generateSlug($name, $allCategorySlugs);
            $allCategorySlugs[$slug] = true;

            $data = [
                'name' => $name,
                'slug' => $slug,
                'is_active' => $isActive,
                'updated_at' => now(),
            ];

            if (isset($existingSlugs[$eleventaId])) {
                $toUpdate[] = ['eleventa_id' => $eleventaId, 'data' => $data];
            } else {
                $toInsert[] = array_merge($data, [
                    'eleventa_id' => $eleventaId,
                    'created_at' => now(),
                ]);
            }
            $synced++;
        }

        if (!$this->dryRun) {
            foreach (array_chunk($toInsert, 500) as $chunk) {
                DB::table('categories')->insert($chunk);
            }
            foreach ($toUpdate as $item) {
                DB::table('categories')->where('eleventa_id', $item['eleventa_id'])->update($item['data']);
            }
        }

        $this->info("  {$synced} categories synced.");
    }

    // ── Brands ← PROVEEDORES ────────────────────────────────────────────────

    private function syncBrands(): void
    {
        $this->info('Syncing brands...');

        $rows = $this->firebird
            ->query("SELECT ID, TRIM(NOMBRE) AS NOMBRE FROM PROVEEDORES WHERE BORRADO_EN IS NULL ORDER BY ID")
            ->fetchAll(PDO::FETCH_OBJ);

        $existingSlugs = DB::table('brands')
            ->whereNotNull('eleventa_id')
            ->pluck('slug', 'eleventa_id')
            ->toArray();

        $allBrandSlugs = DB::table('brands')->pluck('slug')->flip()->toArray();

        $synced = 0;
        $toInsert = [];
        $toUpdate = [];

        foreach ($rows as $prov) {
            $name = $this->utf8($prov->NOMBRE);
            if ($name === '') {
                continue;
            }

            $eleventaId = (int)$prov->ID;

            if ($this->dryRun) {
                $this->line("  [brand] id={$eleventaId} name={$name}");
                $synced++;
                continue;
            }

            $slug = $existingSlugs[$eleventaId] ?? $this->generateSlug($name, $allBrandSlugs);
            $allBrandSlugs[$slug] = true;

            $data = [
                'name' => $name,
                'slug' => $slug,
                'is_active' => 1,
                'updated_at' => now(),
            ];

            if (isset($existingSlugs[$eleventaId])) {
                $toUpdate[] = ['eleventa_id' => $eleventaId, 'data' => $data];
            } else {
                $toInsert[] = array_merge($data, [
                    'eleventa_id' => $eleventaId,
                    'created_at' => now(),
                ]);
            }
            $synced++;
        }

        if (!$this->dryRun) {
            foreach (array_chunk($toInsert, 500) as $chunk) {
                DB::table('brands')->insert($chunk);
            }
            foreach ($toUpdate as $item) {
                DB::table('brands')->where('eleventa_id', $item['eleventa_id'])->update($item['data']);
            }
        }

        $this->info("  {$synced} brands synced.");
    }

    // ── Products ← PRODUCTOS ────────────────────────────────────────────────

    private function syncProducts(): void
    {
        $this->info('Syncing products...');

        $sql = "SELECT ID, TRIM(CODIGO) AS CODIGO, TRIM(DESCRIPCION) AS DESCRIPCION,
                       PVENTA, PCOSTO,
                       DEPT, PROVID, ELIMINADO_EN
                FROM PRODUCTOS ORDER BY ID";

        $rows = $this->firebird->query($sql)->fetchAll(PDO::FETCH_OBJ);

        $categoryMap = DB::table('categories')
            ->whereNotNull('eleventa_id')
            ->pluck('id_category', 'eleventa_id');

        $brandMap = DB::table('brands')
            ->whereNotNull('eleventa_id')
            ->pluck('id_brand', 'eleventa_id');

        // Load ALL existing product SKUs in one query
        $existingProducts = DB::table('products')
            ->pluck('sku')
            ->flip()
            ->toArray();

        $allProductSlugs = DB::table('products')->pluck('slug')->flip()->toArray();

        $synced = 0;
        $skipped = 0;
        $toInsert = [];
        $toUpdate = [];

        foreach ($rows as $prod) {
            $codigo = $this->utf8($prod->CODIGO);
            $nombre = $this->utf8($prod->DESCRIPCION);

            if ($codigo === '' || $nombre === '') {
                $skipped++;
                continue;
            }
            if (!empty(trim($prod->ELIMINADO_EN ?? ''))) {
                $skipped++;
                continue;
            }

            $price = round((float)($prod->PVENTA ?? 0), 2);
            $costPrice = round((float)($prod->PCOSTO ?? 0), 2);
            $categoryId = isset($prod->DEPT) ? ($categoryMap[(int)$prod->DEPT] ?? null) : null;
            $brandId = ($prod->PROVID > 0) ? ($brandMap[(int)$prod->PROVID] ?? null) : null;

            if ($this->dryRun) {
                $this->line("  [prod] sku={$codigo} name={$nombre} price={$price}");
                $synced++;
                continue;
            }

            $data = [
                'name' => $nombre,
                'category_id' => $categoryId,
                'brand_id' => $brandId,
                'cost_price' => $costPrice ?: null,
                'price' => $price ?: null,
                'is_active' => 1,
                'updated_at' => now(),
                'meta' => json_encode(['eleventa_id' => (int)$prod->ID]),
            ];

            if (isset($existingProducts[$codigo])) {
                $toUpdate[] = ['sku' => $codigo, 'data' => $data];
            } else {
                $slug = $this->generateSlug($nombre, $allProductSlugs);
                $allProductSlugs[$slug] = true;

                $toInsert[] = array_merge($data, [
                    'sku' => $codigo,
                    'slug' => $slug,
                    'created_at' => now(),
                ]);
            }
            $synced++;
        }

        if (!$this->dryRun) {
            // Bulk insert new products
            foreach (array_chunk($toInsert, 500) as $chunk) {
                DB::table('products')->insert($chunk);
            }

            // Batch updates (grouped by identical data to minimize queries)
            foreach (array_chunk($toUpdate, 100) as $chunk) {
                foreach ($chunk as $item) {
                    DB::table('products')->where('sku', $item['sku'])->update($item['data']);
                }
            }
        }

        $this->info("  {$synced} products synced, {$skipped} skipped.");
    }

    // ── Cleanup: remove records no longer in Eleventa ────────────────────────

    private function cleanupOrphans(): void
    {
        $this->info('Cleaning up orphaned records...');

        // ── Categories: get all valid eleventa IDs ──
        $validCatIds = collect(
            $this->firebird
                ->query("SELECT ID, TRIM(NOMBRE) AS NOMBRE, ACTIVO FROM DEPARTAMENTOS ORDER BY ID")
                ->fetchAll(PDO::FETCH_OBJ)
        )->filter(function ($dept) {
            if (in_array((int)$dept->ID, $this->skipDeptIds)) return false;
            $name = $this->utf8($dept->NOMBRE);
            if ($name === '') return false;
            if (trim($dept->ACTIVO ?? '') !== '1') return false;
            foreach ($this->skipDeptNames as $skip) {
                if (stripos($name, $skip) !== false) return false;
            }
            return true;
        })->pluck('ID')->map(fn ($id) => (int)$id)->toArray();

        $deletedCats = 0;
        if (!empty($validCatIds)) {
            $deletedCats = DB::table('categories')
                ->whereNotNull('eleventa_id')
                ->whereNotIn('eleventa_id', $validCatIds)
                ->count();

            if (!$this->dryRun && $deletedCats > 0) {
                DB::table('categories')
                    ->whereNotNull('eleventa_id')
                    ->whereNotIn('eleventa_id', $validCatIds)
                    ->delete();
            }
        }
        $this->info("  {$deletedCats} categories removed.");

        // ── Brands: get all valid eleventa IDs ──
        $validBrandIds = collect(
            $this->firebird
                ->query("SELECT ID FROM PROVEEDORES WHERE BORRADO_EN IS NULL ORDER BY ID")
                ->fetchAll(PDO::FETCH_OBJ)
        )->pluck('ID')->map(fn ($id) => (int)$id)->toArray();

        $deletedBrands = 0;
        if (!empty($validBrandIds)) {
            $deletedBrands = DB::table('brands')
                ->whereNotNull('eleventa_id')
                ->whereNotIn('eleventa_id', $validBrandIds)
                ->count();

            if (!$this->dryRun && $deletedBrands > 0) {
                DB::table('brands')
                    ->whereNotNull('eleventa_id')
                    ->whereNotIn('eleventa_id', $validBrandIds)
                    ->delete();
            }
        }
        $this->info("  {$deletedBrands} brands removed.");

        // ── Products: get all valid SKUs from Eleventa ──
        $validSkus = collect(
            $this->firebird
                ->query("SELECT TRIM(CODIGO) AS CODIGO, TRIM(DESCRIPCION) AS DESCRIPCION, ELIMINADO_EN FROM PRODUCTOS ORDER BY ID")
                ->fetchAll(PDO::FETCH_OBJ)
        )->filter(function ($prod) {
            $codigo = $this->utf8($prod->CODIGO);
            $nombre = $this->utf8($prod->DESCRIPCION);
            if ($codigo === '' || $nombre === '') return false;
            if (!empty(trim($prod->ELIMINADO_EN ?? ''))) return false;
            return true;
        })->map(fn ($prod) => $this->utf8($prod->CODIGO))->toArray();

        $deletedProds = 0;
        if (!empty($validSkus)) {
            // Only delete products that came from Eleventa (have eleventa_id in meta)
            $eleventaProducts = DB::table('products')
                ->where('meta', 'like', '%eleventa_id%')
                ->whereNotIn('sku', $validSkus)
                ->get();

            $deletedProds = $eleventaProducts->count();

            if (!$this->dryRun && $deletedProds > 0) {
                DB::table('products')
                    ->where('meta', 'like', '%eleventa_id%')
                    ->whereNotIn('sku', $validSkus)
                    ->delete();
            }
        }
        $this->info("  {$deletedProds} products removed.");
    }

    // ── Helpers ──────────────────────────────────────────────────────────────

    private function utf8(?string $str): string
    {
        if ($str === null) {
            return '';
        }
        return mb_convert_encoding(trim($str), 'UTF-8', 'Windows-1252');
    }

    private function generateSlug(string $name, array &$usedSlugs): string
    {
        $base = Str::slug($name) ?: 'item';
        $slug = $base;
        $i = 1;
        while (isset($usedSlugs[$slug])) {
            $slug = "{$base}-{$i}";
            $i++;
        }
        return $slug;
    }
}
