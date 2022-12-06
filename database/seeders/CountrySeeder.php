<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('countries')->truncate();

        $countries = $this->collectCountries(
            database_path('data/countries.json')
        );

        $countries->each(function (array $country) {
            Country::create($this->uploadFlag($country));
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * @param  string  $countriesFile
     * @return \Illuminate\Support\Collection
     */
    private function collectCountries(string $countriesFile): Collection
    {
        return collect(json_decode(file_get_contents($countriesFile), true));
    }

    /**
     * @param  array  $country
     * @return array
     */
    function uploadFlag(array $country): array
    {
        if (array_key_exists('flag', $country)) {
            Storage::disk('public')->put(
                'flags/'.$country['flag'],
                file_get_contents(database_path('data/flags/'.$country['flag']))
            );

            $country['flag'] = 'flags/'.$country['flag'];
        }

        return $country;
    }
}
