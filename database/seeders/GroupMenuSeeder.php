<?php

namespace Database\Seeders;

use App\Models\GroupMenu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GroupMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $array = [
            ['name' => 'Slider', 'route' => 'slider', 'icon' => 'ShoppingBag', 'order' => 1],
            ['name' => 'Noticias', 'route' => 'noticias', 'icon' => 'ShoppingCart', 'order' => 2],
            ['name' => 'Proyectos', 'route' => 'proyectos', 'icon' => 'Package', 'order' => 3],
        ];

        foreach ($array as $item) {
            GroupMenu::create($item);
        }
    }
}
