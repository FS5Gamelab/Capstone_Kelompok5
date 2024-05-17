<?php

namespace Database\Seeders;

use App\Models\Customer;
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

        Customer::create([
            "user_id" => $user->id,
            "name" => "Test Name",
        ]);
        Customer::create([
            "user_id" => $user2->id,
            "name" => "Admin Test",
        ]);
    }
}
