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
            'address_id' => 0,
            'payment_method' => $this->faker->randomElement(['momo', 'cod']),
            'shipping_fee' => $this->faker->numberBetween(0, 10) * 1000,
        ];
    }
}
