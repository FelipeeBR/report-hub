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

        return [
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->text(),
            'price' => $this->faker->randomFloat(2, 0, 1000),
            'created_at' => $date,
            'updated_at' => $date
        ];
    }
}
