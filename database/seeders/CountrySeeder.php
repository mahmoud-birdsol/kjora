<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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

        // Get the file...
        $countriesFile = database_path('data/countries.json');

        // Collect the data...
        $countries = collect(json_decode(file_get_contents($countriesFile), true));

        $countries->each(function (array $country) {
            // Upload the flag
            if (array_key_exists('flag', $country)) {
                $flag = database_path('data/flags/'.$country['flag']);
                Storage::disk('public')->put('flags/'.$country['flag'], file_get_contents($flag));
                $country['flag'] = 'flags/'.$country['flag'];
            }

            Country::create($country);
        });

        Schema::enableForeignKeyConstraints();
    }
}
