<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CookiePolicy>
 */
class CookiePolicyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'version' => $this->faker->semver(),
            'content' => $this->faker->paragraph(),
            'published_at' => now(),
        ];
    }
}
