<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $products = ProductVariant::all();
        $addresses = Address::factory(10)->create();

        $users->each(function ($user) use ($addresses, $products, $users) {
            Order::factory(5)->for($addresses->random())
                ->for($users->random(), 'buyer')
                ->hasAttached(
                    $products->random(5),
                    ['quantity' => rand(1, 9), 'price' => rand(10000, 90000000)],
                    'orderProducts'
                )->create();
        });
    }
}
