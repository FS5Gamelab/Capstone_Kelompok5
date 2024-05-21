<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
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
        // User::factory(10)->create();


        $user = User::factory()->create([
            'email' => 'test@example.com',
        ]);
        $user2 = User::factory()->create([
            'email' => 'test2@example.com',
            "role" => "admin",
        ]);

        $category = Category::create([
            "category_name" => "Test Category",
            "user_id" => $user2->id
        ]);

        $product = Product::create([
            "category_id" => $category->id,
            "product_name" => "Test Product",
            "type" => "Test Type",
            "description" => "Test Description",
            "price" => rand(100000, 999999),
            "product_image" => "test.png",
            "in_stock" => true,
            "user_id" => $user2->id,
            "quantity" => 5
        ]);

        $product2 = Product::create([
            "category_id" => $category->id,
            "product_name" => "Test Product 2",
            "type" => "Test Type 2",
            "description" => "Test Description 2",
            "price" => rand(100000, 999999),
            "product_image" => "test.png",
            "in_stock" => true,
            "user_id" => $user2->id,
            "quantity" => 3
        ]);
    }
}
