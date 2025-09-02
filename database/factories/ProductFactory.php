<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        $date = $this->faker->dateTimeBetween('-1 year', 'now');

        $products = [
            'Iphone 16',
            'Notebook Acer',
            'Tablet Samsung',
            'TV Samsung',
            'Monitor AOC',
            'Fones de Ouvido',
            'Camera Nikon',
            'Playstation 5',
            'Smartwatch Samsung',
            'Rtx 3060',
            'Mouse Razer',
            'Impressora HP',
            'Roteador TP-Link',
            'Monitor Dell',
            'Impressora Canon',
            'Teclado Razer',
            'Xbox Series X',
            'Monitor LG',
            'Impressora Brother',
            'Teclado Logitech',
            'Xbox Series S',
            'Drone Dji',
            'Fonte Corsair',
            'Rx 550',
        ];

        return [
            'name' => $this->faker->randomElement($products),
            'description' => $this->faker->sentence(10),
            'price' => $this->faker->randomFloat(2, 0, 1000),
            'created_at' => $date,
            'updated_at' => $date
        ];
    }
}
