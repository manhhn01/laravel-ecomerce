<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Color;
use App\Models\Size;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * @var User
     */
    protected $customers;

    /**
     * @var Category
     */
    protected $categories;

    /**
     * @var Color
     */
    protected $colors;

    /**
     * @var Size
     */
    protected $sizes;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(ColorSeeder::class);
        $this->call(SizeSeeder::class);
        $this->call(TagSeeder::class);
        $this->call(SubdivisionSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(OptionSeeder::class);
        $this->call(OrderSeeder::class);
    }
}
