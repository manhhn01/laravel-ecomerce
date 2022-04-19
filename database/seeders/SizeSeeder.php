<?php

namespace Database\Seeders;

use App\Models\Size;
use Illuminate\Database\Seeder;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect(['S', 'M', 'L', 'XL', '2XL'])->each(function ($element) {
            Size::create(['name' => $element]);
        });
    }
}
