<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->lexify('Product ???'),
            'slug' => $this->faker->slug(),
            'price' => $this->faker->numberBetween(99, 999)*1000,
            'sale_price' => rand(0, 1) ? $this->faker->numberBetween(1, 98)*1000 : null,
            'description' => $this->faker->words(5, true),
            'status' => rand(0, 1),
        ];
    }
}
