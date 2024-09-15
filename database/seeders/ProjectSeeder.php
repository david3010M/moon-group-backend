<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'https://develop.garzasoft.com/moon-group-backend/storage/app/public/projectSeeder/header_1_small-01.png',
            'https://develop.garzasoft.com/moon-group-backend/storage/app/public/projectSeeder/header_2_small-02.png',
            'https://develop.garzasoft.com/moon-group-backend/storage/app/public/projectSeeder/header_3_small-03.png',
            'https://develop.garzasoft.com/moon-group-backend/storage/app/public/projectSeeder/header_4_slider-thumb2.png',
        ];
        foreach ($data as $route) {
            Project::factory()->create([
                'headerImage' => $route,
            ]);
        }
    }
}
