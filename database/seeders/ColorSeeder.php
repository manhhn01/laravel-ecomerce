<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $colorContent = file_get_contents(__DIR__.'/data/color.json');
        $colors = json_decode($colorContent);
        collect($colors)->each(function ($element) {
            Color::create(['name' => $element]);
        });
    }
}
