<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'titleEn' => $this->faker->sentence,
            'date' => Carbon::create(2024)->addDays(rand(0, 250))->format('Y-m-d'),
            'introduction' => $this->faker->paragraph,
            'introductionEn' => $this->faker->paragraph,
            'description' => $this->faker->paragraph,
            'descriptionEn' => $this->faker->paragraph,
            'active' => true,
        ];
    }
}
