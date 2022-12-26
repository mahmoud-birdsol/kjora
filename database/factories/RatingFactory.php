<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rating>
 */
class RatingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'rating_from' => $this->faker->randomFloat(2),
            'rating_to' => $this->faker->randomFloat(2),
            'hourly_rate' => $this->faker->randomFloat(2),
        ];
    }
}
