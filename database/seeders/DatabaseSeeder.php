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
            'email' => 'user@gmail.com',
        ]);
        $user2 = User::factory()->create([
            'email' => 'admin@gmail.com',
            "role" => "admin",
        ]);
        $user3 = User::factory()->create([
            'email' => 'superadmin@gmail.com',
            "role" => "super admin",
        ]);;
    }
}
