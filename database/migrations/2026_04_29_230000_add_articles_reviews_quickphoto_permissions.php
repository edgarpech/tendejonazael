<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Agrega los permisos faltantes para los nuevos módulos:
 *  - articles (CRUD)
 *  - reviews (CRUD)
 *  - products.quick-photo (subir fotos vía escáner)
 *
 * Los asigna a los roles existentes (admin: todo, worker: gestión, apprentice: solo view).
 * Es idempotente: usa upserts por nombre, así que puede ejecutarse en local y producción.
 */
return new class extends Migration
{
    public function up(): void
    {
        $now = now();

        $permissions = [
            // Articles
            ['name' => 'articles.view', 'display_name' => 'Ver artículos', 'module' => 'articles', 'action' => 'view'],
            ['name' => 'articles.create', 'display_name' => 'Crear artículos', 'module' => 'articles', 'action' => 'create'],
            ['name' => 'articles.edit', 'display_name' => 'Editar artículos', 'module' => 'articles', 'action' => 'edit'],
            ['name' => 'articles.delete', 'display_name' => 'Eliminar artículos', 'module' => 'articles', 'action' => 'delete'],

            // Reviews
            ['name' => 'reviews.view', 'display_name' => 'Ver reseñas', 'module' => 'reviews', 'action' => 'view'],
            ['name' => 'reviews.create', 'display_name' => 'Crear reseñas', 'module' => 'reviews', 'action' => 'create'],
            ['name' => 'reviews.edit', 'display_name' => 'Editar reseñas', 'module' => 'reviews', 'action' => 'edit'],
            ['name' => 'reviews.delete', 'display_name' => 'Eliminar reseñas', 'module' => 'reviews', 'action' => 'delete'],

            // Quick photo (escáner de código de barras + subida rápida de imagen)
            ['name' => 'products.quick-photo', 'display_name' => 'Subir fotos con escáner', 'module' => 'products', 'action' => 'quick-photo'],
        ];

        foreach ($permissions as $perm) {
            DB::table('permissions')->updateOrInsert(
                ['name' => $perm['name']],
                array_merge($perm, [
                    'is_active' => 1,
                    'updated_at' => $now,
                    'created_at' => $now,
                ])
            );
        }

        // Recoger ids
        $names = array_column($permissions, 'name');
        $allIds = DB::table('permissions')->whereIn('name', $names)->pluck('id_permission', 'name');

        $adminId = DB::table('roles')->where('name', 'admin')->value('id_role');
        $workerId = DB::table('roles')->where('name', 'worker')->value('id_role');
        $apprenticeId = DB::table('roles')->where('name', 'apprentice')->value('id_role');

        // Admin: todos
        if ($adminId) {
            $this->attachPermissions($adminId, $allIds->values()->all(), $now);
        }

        // Worker: gestiona articles, reviews y quick-photo
        if ($workerId) {
            $workerPerms = $allIds->only([
                'articles.view', 'articles.create', 'articles.edit', 'articles.delete',
                'reviews.view', 'reviews.edit', 'reviews.delete',
                'products.quick-photo',
            ])->values()->all();
            $this->attachPermissions($workerId, $workerPerms, $now);
        }

        // Apprentice: solo lectura
        if ($apprenticeId) {
            $apprenticePerms = $allIds->only(['articles.view', 'reviews.view'])->values()->all();
            $this->attachPermissions($apprenticeId, $apprenticePerms, $now);
        }
    }

    public function down(): void
    {
        $names = [
            'articles.view', 'articles.create', 'articles.edit', 'articles.delete',
            'reviews.view', 'reviews.create', 'reviews.edit', 'reviews.delete',
            'products.quick-photo',
        ];

        $ids = DB::table('permissions')->whereIn('name', $names)->pluck('id_permission')->all();
        if (!empty($ids)) {
            DB::table('role_permission')->whereIn('permission_id', $ids)->delete();
            DB::table('permissions')->whereIn('id_permission', $ids)->delete();
        }
    }

    /**
     * Inserta filas en role_permission evitando duplicados.
     */
    private function attachPermissions(int $roleId, array $permissionIds, $now): void
    {
        if (empty($permissionIds)) {
            return;
        }

        $existing = DB::table('role_permission')
            ->where('role_id', $roleId)
            ->whereIn('permission_id', $permissionIds)
            ->pluck('permission_id')
            ->all();

        $toInsert = array_diff($permissionIds, $existing);
        if (empty($toInsert)) {
            return;
        }

        $rows = [];
        foreach ($toInsert as $pid) {
            $rows[] = [
                'role_id' => $roleId,
                'permission_id' => $pid,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        DB::table('role_permission')->insert($rows);
    }
};
