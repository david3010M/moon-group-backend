<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Project;
use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['route' => 'https://develop.garzasoft.com/moon-group-backend/storage/app/public/projectSeeder/m_image01.png'],
            ['route' => 'https://develop.garzasoft.com/moon-group-backend/storage/app/public/projectSeeder/m_image02.png'],
            ['route' => 'https://develop.garzasoft.com/moon-group-backend/storage/app/public/projectSeeder/m_image03.png'],
            ['route' => 'https://develop.garzasoft.com/moon-group-backend/storage/app/public/projectSeeder/m_image04.png'],
            ['route' => 'https://develop.garzasoft.com/moon-group-backend/storage/app/public/projectSeeder/m_image05.png'],
        ];

        $projects = Project::all();
        foreach ($projects as $project) {
            foreach ($data as $image) {
                Image::create([
                    'route' => $image['route'],
                    'project_id' => $project->id,
                ]);
            }
        }
    }
}
