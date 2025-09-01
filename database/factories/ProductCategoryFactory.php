<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        $product = Product::inRandomOrder()->first() ?? Product::factory()->create();
        $category = Category::inRandomOrder()->first() ?? Category::factory()->create();
        return [
            'product_id' => $product->id,
            'category_id' => $category->id
        ];
    }
}
