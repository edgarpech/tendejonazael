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
                'active' => true,
            ],
            [
                'name' => 'Bimbo',
                'description' => 'Pan y productos de panadería',
                'active' => true,
            ],
            [
                'name' => 'Sabritas',
                'description' => 'Botanas y frituras',
                'active' => true,
            ],
            [
                'name' => 'Gamesa',
                'description' => 'Galletas y productos dulces',
                'active' => true,
            ],
            [
                'name' => 'Lala',
                'description' => 'Productos lácteos',
                'active' => true,
            ],
            [
                'name' => 'Ricolino',
                'description' => 'Dulces y chocolates',
                'active' => true,
            ],
            [
                'name' => 'Barcel',
                'description' => 'Botanas y golosinas',
                'active' => true,
            ],
            [
                'name' => 'Fud',
                'description' => 'Embutidos y carnes frías',
                'active' => true,
            ],
            [
                'name' => 'La Lupita',
                'description' => 'Tostadas y productos de maíz',
                'active' => true,
            ],
            [
                'name' => 'Herdez',
                'description' => 'Enlatados y conservas',
                'active' => true,
            ],
            [
                'name' => 'Carnation',
                'description' => 'Leche y productos lácteos',
                'active' => true,
            ],
            [
                'name' => 'McCormick',
                'description' => 'Mayonesas y aderezos',
                'active' => true,
            ],
            [
                'name' => 'La Sierra',
                'description' => 'Frijoles y leguminosas',
                'active' => true,
            ],
            [
                'name' => 'Marinela',
                'description' => 'Pastelitos y galletas',
                'active' => true,
            ],
            [
                'name' => 'Pepsi',
                'description' => 'Bebidas refrescantes',
                'active' => true,
            ],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }

        $this->command->info('Marcas creadas exitosamente!');
    }
}