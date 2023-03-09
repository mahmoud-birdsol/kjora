<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CommentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'parent_id' => null,
            'body' => $this->faker->word(),
            'commentable_id' => $this->faker->randomNumber(),
            'commentable_type' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'user_id' => User::factory(),
        ];
    }
}
