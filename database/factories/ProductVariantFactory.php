<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductVariantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'sku' => $this->faker->lexify('SP-???-???-??'),
            'price' => $this->faker->numberBetween(99, 999)*1000,
            'sale_price' => rand(0, 1) ? $this->faker->numberBetween(1, 98)*1000 : null,
            'quantity' => $this->faker->numberBetween(99, 1999),
        ];
    }
}
