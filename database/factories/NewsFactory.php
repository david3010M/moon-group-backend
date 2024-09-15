<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class NewsFactory extends Factory
{
    public function definition(): array
    {
        $images = [
            'https://develop.garzasoft.com/moon-group-backend/storage/app/public/newsSeeder/post1.png',
            'https://develop.garzasoft.com/moon-group-backend/storage/app/public/newsSeeder/post2.png',
        ];
        return [
            'title' => $this->faker->sentence,
            'date' => $this->faker->date,
            'introduction' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'image' => $images[rand(0, 1)],
            'category_id' => null,
        ];
    }
}
