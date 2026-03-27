<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use PDO;
use Throwable;

/**
 * Comando de sincronización con Eleventa POS.
 *
 * Sincroniza categorías, marcas y productos desde la base de datos Firebird
 * del sistema punto de venta Eleventa hacia la base de datos de Laravel.
 * Soporta modo dry-run para previsualizar cambios.
 */
class EleventaSync extends Command
{
    protected $signature = 'eleventa:sync
                            {--dry-run : Show what would be synced without making changes}';

    protected $description = 'Sync products, categories and brands from Eleventa POS (Firebird DB)';

    private string $fbDatabase;
    private string $fbUser;
    private string $fbPassword;

    private array $skipDeptIds = [2]; // "Productos Comunes"
    private array $skipDeptNames = ['Eliminado', 'Sin Departamento'];

    private PDO $firebird;
    private bool $dryRun = false;

    /**
     * Ejecuta la sincronización completa: conecta a Firebird y sincroniza
     * categorías, marcas, productos y limpia huérfanos.
     *
     * @return int Código de salida (SUCCESS o FAILURE).
     */
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

        DB::beginTransaction();
        try {
            $this->syncCategories();
            $this->syncBrands();
            $this->syncProducts();
            $this->cleanupOrphans();

            if (!$this->dryRun) {
                DB::commit();
            } else {
                DB::rollBack();
            }
        } catch (Throwable $e) {
            DB::rollBack();
            $this->error('Sync failed: ' . $e->getMessage());
            return self::FAILURE;
        }

        $this->newLine();
        $this->info('Sync completed.');
        return self::SUCCESS;
    }

    /**
     * Sincroniza categorías desde la tabla DEPARTAMENTOS de Firebird.
     * Filtra departamentos inactivos y los definidos en skipDeptIds/skipDeptNames.
     *
     * @return void
     */
    private function syncCategories(): void
    {
        $this->info('Syncing categories...');

        $rows = $this->firebird
            ->query("SELECT ID, TRIM(NOMBRE) AS NOMBRE, ACTIVO FROM DEPARTAMENTOS ORDER BY ID")
            ->fetchAll(PDO::FETCH_OBJ);

        // Mapeo de eleventa_id a slug para evitar regenerar slugs de categorías existentes
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
                'updated_at' => now()->toDateTimeString(),
            ];

            if (isset($existingSlugs[$eleventaId])) {
                $toUpdate[] = array_merge(['eleventa_id' => $eleventaId], $data);
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
            if (!empty($toUpdate)) {
                $this->bulkUpdateBy('categories', 'eleventa_id', $toUpdate, ['name', 'slug', 'is_active', 'updated_at']);
            }
        }

        $this->info("  {$synced} categories synced.");
    }

    /**
     * Sincroniza marcas desde la tabla PROVEEDORES de Firebird.
     * Solo importa proveedores no borrados.
     *
     * @return void
     */
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
                'updated_at' => now()->toDateTimeString(),
            ];

            if (isset($existingSlugs[$eleventaId])) {
                $toUpdate[] = array_merge(['eleventa_id' => $eleventaId], $data);
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
            if (!empty($toUpdate)) {
                $this->bulkUpdateBy('brands', 'eleventa_id', $toUpdate, ['name', 'slug', 'is_active', 'updated_at']);
            }
        }

        $this->info("  {$synced} brands synced.");
    }

    /**
     * Sincroniza productos desde la tabla PRODUCTOS de Firebird.
     * Mapea departamentos a categorías y proveedores a marcas.
     *
     * @return void
     */
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

            // Skip products without department or with skipped department
            $deptId = (int)($prod->DEPT ?? 0);
            if ($deptId === 0 || in_array($deptId, $this->skipDeptIds)) {
                $skipped++;
                continue;
            }

            $price = round((float)($prod->PVENTA ?? 0), 2);
            $costPrice = round((float)($prod->PCOSTO ?? 0), 2);
            $categoryId = $categoryMap[$deptId] ?? null;
            $brandId = ($prod->PROVID > 0) ? ($brandMap[(int)$prod->PROVID] ?? null) : null;

            // Skip if department was filtered out (e.g. Sin Departamento)
            if ($categoryId === null) {
                $skipped++;
                continue;
            }

            if ($this->dryRun) {
                $this->line("  [prod] sku={$codigo} name={$nombre} price={$price}");
                $synced++;
                continue;
            }

            $now = now()->toDateTimeString();
            $meta = json_encode(['eleventa_id' => (int)$prod->ID]);

            if (isset($existingProducts[$codigo])) {
                $toUpdate[] = [
                    'sku' => $codigo,
                    'name' => $nombre,
                    'category_id' => $categoryId,
                    'brand_id' => $brandId,
                    'cost_price' => $costPrice ?: null,
                    'price' => $price ?: null,
                    'is_active' => 1,
                    'updated_at' => $now,
                    'meta' => $meta,
                ];
            } else {
                $slug = $this->generateSlug($nombre, $allProductSlugs);
                $allProductSlugs[$slug] = true;

                $toInsert[] = [
                    'sku' => $codigo,
                    'slug' => $slug,
                    'name' => $nombre,
                    'category_id' => $categoryId,
                    'brand_id' => $brandId,
                    'cost_price' => $costPrice ?: null,
                    'price' => $price ?: null,
                    'is_active' => 1,
                    'meta' => $meta,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
            $synced++;
        }

        if (!$this->dryRun) {
            // Bulk insert new products
            foreach (array_chunk($toInsert, 500) as $chunk) {
                DB::table('products')->insert($chunk);
            }

            // Bulk update existing products using PostgreSQL upsert
            $updateFields = ['name', 'category_id', 'brand_id', 'cost_price', 'price', 'is_active', 'updated_at', 'meta'];
            foreach (array_chunk($toUpdate, 500) as $chunk) {
                $this->bulkUpdateBySku($chunk, $updateFields);
            }
        }

        $this->info("  {$synced} products synced, {$skipped} skipped.");
    }

    /**
     * Actualiza productos en lote por SKU usando CASE statements.
     *
     * @param array $rows Filas con datos a actualizar (deben incluir 'sku').
     * @param array $fields Campos a actualizar.
     * @return void
     */
    private function bulkUpdateBySku(array $rows, array $fields): void
    {
        $this->bulkUpdateBy('products', 'sku', $rows, $fields);
    }

    private static array $pgCasts = [
        'is_active' => '::smallint',
        'updated_at' => '::timestamp',
        'created_at' => '::timestamp',
        'deleted_at' => '::timestamp',
        'cost_price' => '::numeric',
        'price' => '::numeric',
        'category_id' => '::integer',
        'brand_id' => '::integer',
        'sort_order' => '::integer',
        'views_count' => '::integer',
        'meta' => '::json',
    ];

    /**
     * Actualiza registros en lote por columna clave usando un solo query con CASE.
     *
     * @param string $table Nombre de la tabla.
     * @param string $keyCol Columna clave para el WHERE/CASE.
     * @param array $rows Filas con datos (deben incluir $keyCol).
     * @param array $fields Campos a actualizar.
     * @return void
     */
    private function bulkUpdateBy(string $table, string $keyCol, array $rows, array $fields): void
    {
        if (empty($rows)) {
            return;
        }

        foreach (array_chunk($rows, 500) as $chunk) {
            $keys = array_column($chunk, $keyCol);
            $bindings = [];
            $cases = [];

            foreach ($fields as $field) {
                $parts = [];
                foreach ($chunk as $row) {
                    $parts[] = "WHEN ? THEN ?";
                    $bindings[] = $row[$keyCol];
                    $bindings[] = $row[$field];
                }
                $cast = self::$pgCasts[$field] ?? '';
                $cases[] = "\"{$field}\" = (CASE \"{$keyCol}\" " . implode(' ', $parts) . " END){$cast}";
            }

            $placeholders = implode(',', array_fill(0, count($keys), '?'));
            $bindings = array_merge($bindings, $keys);

            $sql = "UPDATE \"{$table}\" SET " . implode(', ', $cases) . " WHERE \"{$keyCol}\" IN ({$placeholders})";
            DB::statement($sql, $bindings);
        }
    }

    /**
     * Elimina registros huérfanos que ya no existen en Eleventa.
     * Categorías y marcas se eliminan físicamente; productos se hacen soft delete.
     *
     * @return void
     */
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
                ->whereNull('deleted_at')
                ->get();

            $deletedProds = $eleventaProducts->count();

            if ($deletedProds > 0) {
                foreach ($eleventaProducts as $prod) {
                    $this->line("  [orphan] sku={$prod->sku} name={$prod->name}");
                }
            }

            if (!$this->dryRun && $deletedProds > 0) {
                foreach ($eleventaProducts as $prod) {
                    // Delete image file from disk if present
                    if (!empty($prod->main_image_url)) {
                        Storage::disk('public')->delete($prod->main_image_url);
                    }
                }
                // Soft-delete instead of hard delete
                DB::table('products')
                    ->where('meta', 'like', '%eleventa_id%')
                    ->whereNotIn('sku', $validSkus)
                    ->whereNull('deleted_at')
                    ->update(['deleted_at' => now(), 'is_active' => 0]);
            }
        }
        $this->info("  {$deletedProds} products removed.");
    }

    /**
     * Convierte una cadena de Windows-1252 a UTF-8.
     *
     * @param string|null $str Cadena en codificación Windows-1252.
     * @return string Cadena convertida a UTF-8.
     */
    private function utf8(?string $str): string
    {
        if ($str === null) {
            return '';
        }
        return mb_convert_encoding(trim($str), 'UTF-8', 'Windows-1252');
    }

    /**
     * Genera un slug único a partir de un nombre, evitando duplicados.
     *
     * @param string $name Nombre base para el slug.
     * @param array &$usedSlugs Mapa de slugs ya utilizados (se modifica por referencia).
     * @return string Slug único generado.
     */
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
