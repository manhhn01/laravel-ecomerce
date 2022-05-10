<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\Option;
use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $banners = [];
        for ($i = 0; $i < 4; $i++) {
            $banners[] = ['image' => asset("storage/images/banners/$i.jpg"), 'url' => '/'];
        }
        Option::factory([
            'name' => 'banners',
            'value' => serialize($banners)
        ])->create();

        Option::factory([
            'name' => 'nav_menu',
            'value' => serialize([
                [
                    'name' => 'Hàng mới',
                    'url' => '/new-products'
                ],
                [
                    'name' => 'Sale',
                    'url' => '/sale'
                ],
                [
                    'name' => 'Nam',
                    'url' => '/category/nam'
                ],
                [
                    'name' => 'Nữ',
                    'url' => '/category/nu'
                ],
                [
                    'name' => 'Bộ sưu tập',
                    'url' => '#',
                    'children' => [
                        'name' => 'Bộ sưu tập 1'
                    ]
                ],
                [
                    'name' => 'Blog',
                    'url' => '/blog'
                ],
                [
                    'name' => 'Contact',
                    'url' => '/lien-he'
                ],
            ])
        ])->create();
    }
}
