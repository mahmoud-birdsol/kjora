<?php

namespace Database\Factories;

use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Country>
 */
class CountryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $countries = $this->collectCountries(
            database_path('data/countries.json')
        );

        $filtered = $countries->filter(
            fn ($country) => ! Country::where('name', $country['name'])->count()
        );

        $country = $filtered->first();

        return [
            'name' => $this->faker->country(),
            'code' => $this->faker->countryCode(),
            'calling_code' => '+20',
        ];
    }

    private function collectCountries(string $countriesFile): Collection
    {
        return collect(json_decode(file_get_contents($countriesFile), true));
    }
}
