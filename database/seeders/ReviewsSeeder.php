<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewsSeeder extends Seeder
{
    public function run(): void
    {
        $reviews = [
            [
                'author_name' => 'María García',
                'rating' => 5,
                'comment' => 'Excelente tienda, siempre tienen todo lo que necesitamos para nuestras vacaciones en Chabihau. El trato es muy amable y los precios son justos. ¡Muy recomendada!',
                'source' => 'google',
                'reviewed_at' => now()->subDays(45),
            ],
            [
                'author_name' => 'Carlos Méndez',
                'rating' => 5,
                'comment' => 'Llevamos años viniendo a Chabihau y siempre pasamos al Tendejón Azael. Tienen de todo: desde hielo y refrescos hasta productos de limpieza. Nunca nos ha faltado nada.',
                'source' => 'google',
                'reviewed_at' => now()->subDays(30),
            ],
            [
                'author_name' => 'Laura Domínguez',
                'rating' => 4,
                'comment' => 'Muy buena opción para comprar lo básico sin tener que ir hasta Motul. Aceptan tarjeta, lo cual es genial porque en Chabihau no hay cajeros. Buena variedad de snacks y bebidas.',
                'source' => 'google',
                'reviewed_at' => now()->subDays(20),
            ],
            [
                'author_name' => 'Roberto Pech',
                'rating' => 5,
                'comment' => 'La mejor tienda del pueblo. Siempre abierta, buen surtido y la familia que atiende es muy amable. Cuando venimos de Mérida siempre es nuestra primera parada.',
                'source' => 'google',
                'reviewed_at' => now()->subDays(15),
            ],
            [
                'author_name' => 'Ana Lucia Torres',
                'rating' => 5,
                'comment' => 'Nos encanta este lugar. Vinimos de vacaciones y encontramos todo lo que necesitábamos para la semana. El hielo siempre disponible es un plus enorme en la playa.',
                'source' => 'google',
                'reviewed_at' => now()->subDays(8),
            ],
            [
                'author_name' => 'Fernando Canul',
                'rating' => 4,
                'comment' => 'Buena tienda con productos variados. Los precios son razonables para estar en la costa. Me gusta que tienen marcas conocidas y el horario amplio nos conviene mucho.',
                'source' => 'google',
                'reviewed_at' => now()->subDays(3),
            ],
        ];

        foreach ($reviews as $review) {
            Review::create($review);
        }
    }
}
