<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Run seeders in correct order (dependencies first)
        $this->call([
            CategorySeeder::class,
            UnitSeeder::class,
            ServiceSeeder::class,
            ProjectSeeder::class,
            NewsSeeder::class,
        ]);
    }
}
