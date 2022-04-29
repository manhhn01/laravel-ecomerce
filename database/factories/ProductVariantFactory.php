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
            'sku' => strtoupper($this->faker->lexify('SP-LO-???-??')),
            'quantity' => $this->faker->numberBetween(99, 1999),
            'cover' => 'images/products/' . $this->faker->numberBetween(0, 359) . '.jpeg',
        ];
    }
}
