<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tagContent = file_get_contents(__DIR__.'/data/tag.json');
        $tags = json_decode($tagContent);
        collect($tags)->each(function ($element) {
            Tag::create(['name' => $element]);
        });
    }
}
