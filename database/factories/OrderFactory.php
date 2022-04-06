<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'status' => rand(0, 3),
            'shipping_date' => $this->faker->dateTimeThisYear()
        ];
    }
}
