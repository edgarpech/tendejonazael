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

    // User drops the pdvdata.fdb file here manually
    private string $fbDatabase = 'c:\\xampp\\htdocs\\tendejonazael\\eleventa\\pdvdata.fdb';
    private string $fbUser = 'SYSDBA';
    private string $fbPassword = 'masterkey';

    private array $skipDeptIds = [2]; // "Productos Comunes"
    private array $skipDeptNames = ['Eliminado']; // partial match to skip deleted depts

    private PDO $firebird;
    private bool $dryRun = false;

    public function handle(): int
    {
        $this->dryRun = $this->option('dry-run');

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

        $synced = 0;
        foreach ($rows as $dept) {
            if (in_array((int)$dept->ID, $this->skipDeptIds)) {
                continue;
            }

            $name = $this->utf8($dept->NOMBRE);
            if ($name === '') {
                continue;
            }

            $isActive = trim($dept->ACTIVO ?? '') === '1' ? 1 : 0;

            // Skip inactive or soft-deleted departments
            if (!$isActive) {
                continue;
            }

            // Skip departments whose name contains a skip-word
            foreach ($this->skipDeptNames as $skip) {
                if (stripos($name, $skip) !== false) {
                    continue 2;
                }
            }

            if ($this->dryRun) {
                $this->line("  [cat] id={$dept->ID} name={$name} active={$isActive}");
                $synced++;
                continue;
            }

            $this->upsert('categories', 'eleventa_id', (int)$dept->ID, [
                'name' => $name,
                'slug' => $this->uniqueSlug('categories', $name, 'eleventa_id', (int)$dept->ID),
                'is_active' => $isActive,
            ]);
            $synced++;
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

        $synced = 0;
        foreach ($rows as $prov) {
            $name = $this->utf8($prov->NOMBRE);
            if ($name === '') {
                continue;
            }

            if ($this->dryRun) {
                $this->line("  [brand] id={$prov->ID} name={$name}");
                $synced++;
                continue;
            }

            $this->upsert('brands', 'eleventa_id', (int)$prov->ID, [
                'name' => $name,
                'slug' => $this->uniqueSlug('brands', $name, 'eleventa_id', (int)$prov->ID),
                'is_active' => 1,
            ]);
            $synced++;
        }

        $this->info("  {$synced} brands synced.");
    }

    // ── Products ← PRODUCTOS (upsert only, never deletes) ──────────────────

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

        $synced = 0;
        $skipped = 0;

        foreach ($rows as $prod) {
            $codigo = $this->utf8($prod->CODIGO);
            $nombre = $this->utf8($prod->DESCRIPCION);

            if ($codigo === '' || $nombre === '') {
                $skipped++;
                continue;
            }
            // Skip products that were deleted inside Eleventa
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

            $existing = DB::table('products')->where('sku', $codigo)->first();

            // Fields updated from Eleventa (preserves images, description, slug, etc.)
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

            if ($existing) {
                DB::table('products')->where('sku', $codigo)->update($data);
            } else {
                DB::table('products')->insert(array_merge($data, [
                    'sku' => $codigo,
                    'slug' => $this->uniqueSlug('products', $nombre),
                    'created_at' => now(),
                ]));
            }
            $synced++;
        }

        $this->info("  {$synced} products synced, {$skipped} skipped.");
    }

    // ── Helpers ──────────────────────────────────────────────────────────────

    private function utf8(?string $str): string
    {
        if ($str === null) {
            return '';
        }
        return mb_convert_encoding(trim($str), 'UTF-8', 'Windows-1252');
    }

    private function upsert(string $table, string $keyCol, int $keyVal, array $values): void
    {
        $exists = DB::table($table)->where($keyCol, $keyVal)->exists();
        $values['updated_at'] = now();

        if ($exists) {
            DB::table($table)->where($keyCol, $keyVal)->update($values);
        } else {
            DB::table($table)->insert(array_merge($values, [
                $keyCol => $keyVal,
                'created_at' => now(),
            ]));
        }
    }

    private function uniqueSlug(string $table, string $name, ?string $keyCol = null, ?int $keyVal = null): string
    {
        $base = Str::slug($name) ?: 'item';

        if ($keyCol && $keyVal) {
            $existing = DB::table($table)->where($keyCol, $keyVal)->value('slug');
            if ($existing) {
                return $existing;
            }
        }

        $slug = $base;
        $i = 1;
        while (DB::table($table)->where('slug', $slug)->exists()) {
            $slug = "{$base}-{$i}";
            $i++;
        }
        return $slug;
    }
}
