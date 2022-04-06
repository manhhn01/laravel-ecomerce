<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'state_id' => $this->faker->state(),
            'city_id' => $this->faker->city(),
            'address' => $this->faker->address(),
            'phone' => $this->faker->phoneNumber(),
        ];
    }
}
