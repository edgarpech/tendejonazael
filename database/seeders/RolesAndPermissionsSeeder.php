<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

/**
 * Seeder de roles y permisos.
 *
 * Crea los roles (admin, worker, apprentice) y todos los permisos
 * del sistema agrupados por módulo, asignando todos al rol admin.
 */
class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Crea roles, permisos y asigna todos los permisos al rol administrador.
     *
     * @return void
     */
    public function run(): void
    {
        // Create Roles
        $admin = Role::create([
            'name' => 'admin',
            'display_name' => 'Administrador',
            'description' => 'Acceso total al sistema',
            'level' => 3,
            'is_active' => 1,
        ]);

        $worker = Role::create([
            'name' => 'worker',
            'display_name' => 'Trabajador',
            'description' => 'Puede gestionar productos, categorías, marcas y galería',
            'level' => 2,
            'is_active' => 1,
        ]);

        $apprentice = Role::create([
            'name' => 'apprentice',
            'display_name' => 'Aprendiz',
            'description' => 'Solo lectura',
            'level' => 1,
            'is_active' => 1,
        ]);

        // Create Permissions
        $permissions = [
            // Users
            ['name' => 'users.view', 'display_name' => 'Ver usuarios', 'module' => 'users', 'action' => 'view'],
            ['name' => 'users.create', 'display_name' => 'Crear usuarios', 'module' => 'users', 'action' => 'create'],
            ['name' => 'users.edit', 'display_name' => 'Editar usuarios', 'module' => 'users', 'action' => 'edit'],
            ['name' => 'users.delete', 'display_name' => 'Eliminar usuarios', 'module' => 'users', 'action' => 'delete'],
            
            // Roles
            ['name' => 'roles.view', 'display_name' => 'Ver roles', 'module' => 'roles', 'action' => 'view'],
            ['name' => 'roles.create', 'display_name' => 'Crear roles', 'module' => 'roles', 'action' => 'create'],
            ['name' => 'roles.edit', 'display_name' => 'Editar roles', 'module' => 'roles', 'action' => 'edit'],
            ['name' => 'roles.delete', 'display_name' => 'Eliminar roles', 'module' => 'roles', 'action' => 'delete'],
            
            // Products
            ['name' => 'products.view', 'display_name' => 'Ver productos', 'module' => 'products', 'action' => 'view'],
            ['name' => 'products.create', 'display_name' => 'Crear productos', 'module' => 'products', 'action' => 'create'],
            ['name' => 'products.edit', 'display_name' => 'Editar productos', 'module' => 'products', 'action' => 'edit'],
            ['name' => 'products.delete', 'display_name' => 'Eliminar productos', 'module' => 'products', 'action' => 'delete'],
            
            // Categories
            ['name' => 'categories.view', 'display_name' => 'Ver categorías', 'module' => 'categories', 'action' => 'view'],
            ['name' => 'categories.create', 'display_name' => 'Crear categorías', 'module' => 'categories', 'action' => 'create'],
            ['name' => 'categories.edit', 'display_name' => 'Editar categorías', 'module' => 'categories', 'action' => 'edit'],
            ['name' => 'categories.delete', 'display_name' => 'Eliminar categorías', 'module' => 'categories', 'action' => 'delete'],
            
            // Brands
            ['name' => 'brands.view', 'display_name' => 'Ver marcas', 'module' => 'brands', 'action' => 'view'],
            ['name' => 'brands.create', 'display_name' => 'Crear marcas', 'module' => 'brands', 'action' => 'create'],
            ['name' => 'brands.edit', 'display_name' => 'Editar marcas', 'module' => 'brands', 'action' => 'edit'],
            ['name' => 'brands.delete', 'display_name' => 'Eliminar marcas', 'module' => 'brands', 'action' => 'delete'],
            
            // Gallery
            ['name' => 'gallery.view', 'display_name' => 'Ver galería', 'module' => 'gallery', 'action' => 'view'],
            ['name' => 'gallery.create', 'display_name' => 'Crear galería', 'module' => 'gallery', 'action' => 'create'],
            ['name' => 'gallery.edit', 'display_name' => 'Editar galería', 'module' => 'gallery', 'action' => 'edit'],
            ['name' => 'gallery.delete', 'display_name' => 'Eliminar galería', 'module' => 'gallery', 'action' => 'delete'],
            
            // Configurations
            ['name' => 'configurations.view', 'display_name' => 'Ver configuraciones', 'module' => 'configurations', 'action' => 'view'],
            ['name' => 'configurations.edit', 'display_name' => 'Editar configuraciones', 'module' => 'configurations', 'action' => 'edit'],
        ];

        foreach ($permissions as $permissionData) {
            Permission::create($permissionData);
        }

        // Assign all permissions to admin
        $admin->permissions()->attach(Permission::all());

        // Assign worker permissions (products, categories, brands, gallery)
        $workerPermissions = Permission::whereIn('module', ['products', 'categories', 'brands', 'gallery'])->get();
        $worker->permissions()->attach($workerPermissions);

        // Assign apprentice permissions (only view)
        $apprenticePermissions = Permission::where('action', 'view')->get();
        $apprentice->permissions()->attach($apprenticePermissions);

        echo "✓ Roles and permissions seeded successfully!\n";
    }
}
