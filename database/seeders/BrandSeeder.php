<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            [
                'name' => 'Coca Cola',
                'description' => 'Bebidas refrescantes',
                'is_active' => 1,
            ],
            [
                'name' => 'Bimbo',
                'description' => 'Pan y productos de panadería',
                'is_active' => 1,
            ],
            [
                'name' => 'Sabritas',
                'description' => 'Botanas y frituras',
                'is_active' => 1,
            ],
            [
                'name' => 'Gamesa',
                'description' => 'Galletas y productos dulces',
                'is_active' => 1,
            ],
            [
                'name' => 'Lala',
                'description' => 'Productos lácteos',
                'is_active' => 1,
            ],
            [
                'name' => 'Ricolino',
                'description' => 'Dulces y chocolates',
                'is_active' => 1,
            ],
            [
                'name' => 'Barcel',
                'description' => 'Botanas y golosinas',
                'is_active' => 1,
            ],
            [
                'name' => 'Fud',
                'description' => 'Embutidos y carnes frías',
                'is_active' => 1,
            ],
            [
                'name' => 'La Lupita',
                'description' => 'Tostadas y productos de maíz',
                'is_active' => 1,
            ],
            [
                'name' => 'Herdez',
                'description' => 'Enlatados y conservas',
                'is_active' => 1,
            ],
            [
                'name' => 'Carnation',
                'description' => 'Leche y productos lácteos',
                'is_active' => 1,
            ],
            [
                'name' => 'McCormick',
                'description' => 'Mayonesas y aderezos',
                'is_active' => 1,
            ],
            [
                'name' => 'La Sierra',
                'description' => 'Frijoles y leguminosas',
                'is_active' => 1,
            ],
            [
                'name' => 'Marinela',
                'description' => 'Pastelitos y galletas',
                'is_active' => 1,
            ],
            [
                'name' => 'Pepsi',
                'description' => 'Bebidas refrescantes',
                'is_active' => 1,
            ],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }

        $this->command->info('Marcas creadas exitosamente!');
    }
}
