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
        collect(['Đỏ', 'Trắng', 'Vàng', 'Xanh', 'Tím', 'Đen', 'Trắng'])->each(function ($element) {
            Color::create(['name' => $element]);
        });
    }
}
