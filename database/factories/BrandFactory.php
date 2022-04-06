<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->lexify('brand ???'),
            'description' => $this->faker->words(5, true),
            'slug' => $this->faker->slug(),
            'image' => 'images/brands/default.png',
        ];
    }
}
