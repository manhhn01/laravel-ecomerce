<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{

    private $brandNames = [ "Nike", "Louis Vuitton", "Hermes", "Gucci", "Zalando", "Adidas", "Tiffany & Co.", "Zara", "H&M", "Cartier", "Lululemon", "Moncler", "Chanel", "Rolex", "Patek Philippe", "Prada", "Uniqlo", "Chow Tai Fook", "Swarovski", "Burberry", "Polo Ralph Lauren", "Tom Ford", "Nordstrom", "C&A" ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->brandNames as $brandName) {
            Brand::factory(['name' => $brandName])->create();
        }
    }
}
