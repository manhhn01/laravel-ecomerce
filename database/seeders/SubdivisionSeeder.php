<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\Province;
use App\Models\Ward;
use Illuminate\Database\Seeder;

class SubdivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $divisions = json_decode(file_get_contents(__DIR__ . '/data/vietnam-subdivisions.json'), true);

        foreach ($divisions as $provinceData) {
            $province = Province::factory(['name' => $provinceData['name']])->create();
            foreach ($provinceData['districts'] as $districtData) {
                $district = District::factory(['name' => $districtData['name']])->for($province)->create();
                foreach ($districtData['wards'] as $ward) {
                    Ward::factory(['name' => $ward['name']])->for($district)->create();
                }
            }
        }
    }
}
