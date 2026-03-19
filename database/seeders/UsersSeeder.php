<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();
        $workerRole = Role::where('name', 'worker')->first();

        // Create admin user
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@tendejonazael.com',
            'password' => Hash::make('admin123'),
            'role_id' => $adminRole->id_role,
            'is_active' => 1,
            'email_verified_at' => now(),
        ]);

        // Create worker user
        User::create([
            'name' => 'Trabajador Demo',
            'email' => 'trabajador@tendejonazael.com',
            'password' => Hash::make('trabajador123'),
            'role_id' => $workerRole->id_role,
            'is_active' => 1,
            'email_verified_at' => now(),
        ]);

        echo "✓ Users seeded successfully!\n";
        echo "\nCredenciales de acceso:\n";
        echo "Admin: admin@tendejonazael.com / admin123\n";
        echo "Trabajador: trabajador@tendejonazael.com / trabajador123\n";
    }
}
