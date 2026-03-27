<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Seeder principal de la base de datos.
 *
 * Ejecuta todos los seeders del sistema en orden de dependencia.
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Ejecuta los seeders: roles/permisos, usuarios y configuraciones.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            UsersSeeder::class,
            ConfigurationsSeeder::class,
        ]);
    }
}