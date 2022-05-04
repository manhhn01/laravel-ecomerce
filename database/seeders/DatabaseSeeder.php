<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Image;
use App\Models\ProductVariant;
use App\Models\Review;
use App\Models\Size;
use App\Models\Tag;
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

        $this->customers = User::where('role_id', '!=', 0)->get();
        $this->categories = Category::all();
        $this->colors = Color::all();
        $this->sizes = Size::all();

        $femaleProducts = json_decode(file_get_contents(__DIR__ . "/data/product-female.json"), true);
        $maleProducts = json_decode(file_get_contents(__DIR__ . "/data/product-male.json"), true);
        $kidProducts = json_decode(file_get_contents(__DIR__ . "/data/product-kid.json"), true);

        $this->createProducts($femaleProducts, $this->categories->firstWhere('name', 'Nữ'));
        $this->createProducts($maleProducts, $this->categories->firstWhere('name', 'Nam'));
        $this->createProducts($kidProducts, $this->categories->firstWhere('name', 'Trẻ em'));
    }

    protected function createProducts($products)
    {
        foreach ($products as $productData) {
            $tags = Tag::query();
            foreach ($productData['tags'] as $productTag){
                $tags->orWhere('name', $productTag);
            }
            $tags = $tags->get();

            $product = Product::factory([
                'name' => $productData['name'],
                'slug' => $productData['slug'],
                'cover' => 'images/products/'.basename(parse_url($productData['cover'], PHP_URL_PATH)),
                'description' => $productData['description'],
                'price' => $productData['price'],
                'sale_price' => $productData['sale_price']
            ])
                ->has(
                    Review::factory(5)
                        ->for($this->customers->random())
                )
                ->hasAttached($tags)
                ->for($this->categories->firstWhere('name', $productData['category']))
                ->create();

            foreach ($productData['variants'] as $productVariant) {
                $color = $this->colors->firstWhere('name', $productVariant['color']);
                $size = $this->sizes->firstWhere('name', $productVariant['size']) ?? Size::where('name', 'Free size')->first();

                ProductVariant::factory([
                    'id' => $productVariant['id'],
                    'sku' => $productVariant['sku'],
                    'quantity' => $productVariant['quantity'],
                    'cover' => isset($productVariant['cover']) ? 'images/products/'.basename(parse_url($productVariant['cover'], PHP_URL_PATH)) : 'images/products/'.rand(0, 100).'.jpeg',
                ])
                    ->for($product)
                    ->for($color)
                    ->for($size)
                    ->create();
            }

            foreach ($productData['images'] as $productImage) {
                Image::factory(['image' => 'images/products/'.basename(parse_url($productImage, PHP_URL_PATH))])->for($product, 'imageable')->create();
            }
        }
    }
}
