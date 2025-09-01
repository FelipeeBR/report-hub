<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Sale;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory(10)->create();
        $products = Product::factory(50)->create();
        $categories = Category::factory(10)->create();

        $users->each(function ($user) use ($products) {
            Sale::factory(200)->create([
                'user_id' => $user->id,
                'product_id' => $products->random()->id,
            ]);
        });

        $products->each(function ($product) use ($categories) {
 
            $productCategories = $categories->random(rand(1, 3));

            foreach ($productCategories as $category) {
                ProductCategory::factory()->create([
                    'product_id' => $product->id,
                    'category_id' => $category->id,
                ]);
            }
        });

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
