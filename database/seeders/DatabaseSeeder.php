<?php

namespace Database\Seeders;

use App\Models\News;
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

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->call(ProjectSeeder::class);
        $this->call(ImageSeeder::class);
        $this->call(SliderSeeder::class);
        $this->call(NewsSeeder::class);
    }
}