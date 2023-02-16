<?php

namespace Database\Factories;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'conversation_id' => Conversation::factory(),
            'sender_id' => User::factory(),
            'read_at' => now(),
            'body' => $this->faker->text()
        ];
    }

    /**
     * Indicate that the message is a reply.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function reply(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'parent_id' => Message::factory(),
            ];
        });
    }


}
