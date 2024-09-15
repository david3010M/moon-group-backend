<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'https://develop.garzasoft.com/moon-group-backend/storage/app/public/sliderSeeder/slider1.png',
            'https://develop.garzasoft.com/moon-group-backend/storage/app/public/sliderSeeder/slider2.png',
            'https://develop.garzasoft.com/moon-group-backend/storage/app/public/sliderSeeder/slider3.png',
            'https://develop.garzasoft.com/moon-group-backend/storage/app/public/sliderSeeder/slider4.png',
        ];
        foreach ($data as $index => $route) {
            Slider::factory()->create([
                'route' => $route,
                'order' => ($index + 1),
            ]);
        }
    }
}
