<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stadium>
 */
class StadiumFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'google_place_id' => $this->faker->randomDigit(),
            'country' => $this->faker->country(),
            'city' => $this->faker->city(),
            'street_address' => $this->faker->streetAddress(),
            'longitude' => $this->faker->longitude(),
            'latitude' => $this->faker->latitude(),
            'approved_at' => now(),
        ];
    }
}
