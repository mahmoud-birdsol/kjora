<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class TimeZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        $countries = $this->collectCountries(
            database_path('data/countries.json')
        );

        $countries->each(function (array $data) {
            /** @var Country $country */
            $country = Country::where('code',$data['alpha2Code'] )->first();
            $country->forceFill(['time_zone' => $data['timezones'][0]])->save();
        });

        Schema::enableForeignKeyConstraints();
    }

    private function collectCountries(string $countriesFile): Collection
    {
        return collect(json_decode(file_get_contents($countriesFile), true));
    }
}
