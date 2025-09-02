<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sale>
 */
class SaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        $product = Product::inRandomOrder()->first() ?? Product::factory()->create();
        $quantity = $this->faker->numberBetween(1, 10);
        $date = $this->faker->dateTimeBetween('-2 year', 'now');

        return [
            'user_id'    => User::inRandomOrder()->first()->id ?? User::factory(),
            'product_id' => $product->id,
            'quantity'   => $quantity,
            'total'      => $product->price * $quantity,
            'created_at' => $date,
            'updated_at' => $date
        ];
    }
}
