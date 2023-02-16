<?php

namespace Database\Factories;

use App\Models\Club;
use App\Models\Country;
use App\Models\Position;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'username' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),

            'country_id' => Country::factory(),
            'club_id' => Club::factory(),
            'position_id' => $this->faker->randomElement(Position::all()->pluck('id')->toArray()),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'phone' => $this->faker->phoneNumber(),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'avatar' => $this->faker->imageUrl(),
            'identity_issue_country' => $this->faker->country(),
            'identity_type' => $this->faker->randomElement(['passport', 'national_id']),
            'identity_front_image' => $this->faker->imageUrl(),
            'identity_back_image' => $this->faker->imageUrl(),
            'identity_selfie_image' => $this->faker->imageUrl(),
            'accepted_terms_and_conditions_version' => true,
            'accepted_privacy_policy_version' => '1.0',
            'accepted_cookie_policy_version' => '1.0',
            'date_of_birth' => $this->faker->dateTimeBetween('-50 years', '-20 years'),
            'identity_verified_at' => now(),
            'phone_verified_at' => now(),
            'accepted_terms_and_conditions_at' => now(),
            'accepted_privacy_policy_at' => now(),
            'accepted_cookie_policy_at' => now(),
            'preferred_foot' => $this->faker->randomElement(['left', 'right']),
            'rating' => $this->faker->randomFloat(2, 0, 5),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    /**
     * Indicate that the user should have a personal team.
     *
     * @return $this
     */
    public function withPersonalTeam()
    {
        if (! Features::hasTeamFeatures()) {
            return $this->state([]);
        }

        return $this->has(
            Team::factory()
                ->state(function (array $attributes, User $user) {
                    return ['name' => $user->name.'\'s Team', 'user_id' => $user->id, 'personal_team' => true];
                }),
            'ownedTeams'
        );
    }
}
