<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Factories\WineFactory;
use Illuminate\Database\Seeder;
use App\Models\Wine;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();


        Wine::factory(100)->create([
            'user_id' => 9
        ]);
    }
}
