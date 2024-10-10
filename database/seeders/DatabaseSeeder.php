<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $array = [
            ['names' => 'Moon Group', 'lastnames' => 'Admin', 'username' => 'admin', 'password' => Hash::make('12345678')],
        ];

        foreach ($array as $value) {
            User::create($value);
        }

        $this->call(GroupMenuSeeder::class);
        $this->call(OptionMenuSeeder::class);

        $this->call(ProjectSeeder::class);
        $this->call(ImageSeeder::class);
        $this->call(SliderSeeder::class);
        $this->call(NewsSeeder::class);
    }
}
