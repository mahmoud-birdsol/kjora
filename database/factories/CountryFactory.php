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
            'capital' => $country['capital'],
            'citizenship' => $country['citizenship'],
            'country_code' => $country['country_code'],
            'currency' => $country['currency'],
            'currency_code' => $country['currency_code'],
            'currency_sub_unit' => $country['currency_sub_unit'],
            'full_name' => $country['full_name'],
            'iso_3166_2' => $country['iso_3166_2'],
            'iso_3166_3' => $country['iso_3166_3'],
            'name' => $country['name'],
            'region_code' => $country['region_code'],
            'sub_region_code' => $country['sub_region_code'],
            'eea' => $country['eea'],
            'calling_code' => $country['calling_code'],
            'currency_symbol' => $country['currency_symbol'],
            'currency_decimals' => $country['currency_decimals'],
        ];
    }

    /**
     * @param  string  $countriesFile
     * @return \Illuminate\Support\Collection
     */
    private function collectCountries(string $countriesFile): Collection
    {
        return collect(json_decode(file_get_contents($countriesFile), true));
    }
}
