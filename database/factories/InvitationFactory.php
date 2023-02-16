<?php

namespace Database\Factories;

use App\Models\Stadium;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invitation>
 */
class InvitationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'stadium_id' => Stadium::factory(),
            'inviting_player_id' => User::factory(),
            'invited_player_id' => User::factory(),
            'date' => $this->faker->dateTimeThisYear(),
            'state' => 'accepted',
        ];
    }
}
