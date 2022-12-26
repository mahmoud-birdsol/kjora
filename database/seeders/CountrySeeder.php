<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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

        $countries->each(function (array $data) {
            /** @var Country $country */
            $country = Country::create(collect($data)->except('flag')->toArray());

            if (array_key_exists('flag', $data)) {
                try {
                    $country->addMedia(database_path('data/flags/'.$data['flag']))->toMediaCollection('flag');
                } catch (\Exception $e) {
                    Log::info($e->getMessage());
                }
            }
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
    public function uploadFlag(array $country): array
    {
        return $country;
    }
}
