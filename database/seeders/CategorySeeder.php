<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;

class CategorySeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $female = json_decode(file_get_contents(__DIR__ . '/data/category-female.json'));
        $kid = json_decode(file_get_contents(__DIR__ . '/data/category-kid.json'));
        $male = json_decode(file_get_contents(__DIR__ . '/data/category-male.json'));
        $categoryNames = ['Nam', 'Nữ', 'Trẻ em'];
        $categoriesChild = [$male, $female, $kid];
        foreach ($categoryNames as $index => $categoryName) {
            Category::factory(['name' => $categoryName, 'slug' => Str::slug($categoryName)])->create()
                ->children()->saveMany(
                    collect($categoriesChild[$index])
                        ->map(function ($name) {
                            return Category::factory()->makeOne(['name' => $name]);
                        })
                        ->all()
                );
        }
    }
}
