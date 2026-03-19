<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Bebidas',
                'description' => 'Refrescos, jugos, aguas y bebidas energéticas',
                'is_active' => 1,
            ],
            [
                'name' => 'Lácteos',
                'description' => 'Leche, yogurt, quesos y productos lácteos',
                'is_active' => 1,
            ],
            [
                'name' => 'Limpieza',
                'description' => 'Productos de limpieza para el hogar',
                'is_active' => 1,
            ],
            [
                'name' => 'Cuidado Personal',
                'description' => 'Jabones, shampoos, desodorantes y más',
                'is_active' => 1,
            ],
            [
                'name' => 'Golosinas',
                'description' => 'Dulces, chocolates y snacks dulces',
                'is_active' => 1,
            ],
            [
                'name' => 'Pan Dulce',
                'description' => 'Pan empaquetado y productos de panadería',
                'is_active' => 1,
            ],
            [
                'name' => 'Papelería',
                'description' => 'Útiles escolares y artículos de oficina',
                'is_active' => 1,
            ],
            [
                'name' => 'Botanas',
                'description' => 'Frituras, cacahuates y botanas saladas',
                'is_active' => 1,
            ],
            [
                'name' => 'Abarrotes',
                'description' => 'Productos básicos de despensa',
                'is_active' => 1,
            ],
            [
                'name' => 'Enlatados',
                'description' => 'Conservas y productos enlatados',
                'is_active' => 1,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        $this->command->info('Categorías creadas exitosamente!');
    }
}