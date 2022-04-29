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
        $sizeContent = file_get_contents(__DIR__.'/data/size.json');
        $sizes = json_decode($sizeContent);
        collect($sizes)->each(function ($element) {
            Size::create(['name' => $element]);
        });
    }
}
