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
                'active' => true,
            ],
            [
                'name' => 'Lácteos',
                'description' => 'Leche, yogurt, quesos y productos lácteos',
                'active' => true,
            ],
            [
                'name' => 'Limpieza',
                'description' => 'Productos de limpieza para el hogar',
                'active' => true,
            ],
            [
                'name' => 'Cuidado Personal',
                'description' => 'Jabones, shampoos, desodorantes y más',
                'active' => true,
            ],
            [
                'name' => 'Golosinas',
                'description' => 'Dulces, chocolates y snacks dulces',
                'active' => true,
            ],
            [
                'name' => 'Pan Dulce',
                'description' => 'Pan empaquetado y productos de panadería',
                'active' => true,
            ],
            [
                'name' => 'Papelería',
                'description' => 'Útiles escolares y artículos de oficina',
                'active' => true,
            ],
            [
                'name' => 'Botanas',
                'description' => 'Frituras, cacahuates y botanas saladas',
                'active' => true,
            ],
            [
                'name' => 'Abarrotes',
                'description' => 'Productos básicos de despensa',
                'active' => true,
            ],
            [
                'name' => 'Enlatados',
                'description' => 'Conservas y productos enlatados',
                'active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        $this->command->info('Categorías creadas exitosamente!');
    }
}