<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'comment' => $this->faker->words(10, true),
            'vote' => $this->faker->numberBetween(1, 5),
            'like' => $this->faker->numberBetween(0, 10),
            'status' => rand(0, 1),
        ];
    }
}
