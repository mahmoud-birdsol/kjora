<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

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

//        dd($countries->first());

        $countries->each(function (array $data) {
            /** @var Country $country */
            $country = Country::create([
                'name' => $data['name'],
                'code' => $data['alpha2Code'],
                'calling_code' => $data['callingCodes'][0]
            ]);

            if (array_key_exists('flags', $data)) {
                try {
                    $country->addMediaFromUrl($data['flags']["svg"])->toMediaCollection('flag');
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
}
