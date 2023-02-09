<?php

namespace Database\Seeders;

use App\Models\Club;
use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class ClubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('clubs')->truncate();

        $clubCountries = [
            'england',
//            'spain',
//            'italy',
//            'germany',
//            'france',
//            'saudi-arabia',
//            'kuwait',
//            'scotland',
//            'argentina',
//            'australia',
//            'japan',
//            'usa',
//            'netherlands',
//            'portugal',
//            'turkey',
//            'qatar',
//            'united-arab-emirates',
//            'bahrain',
//            'oman',
//            'egypt',
//            'brazil',
//            'russia',
//            'denmark',
//            'ukraine',
//            'czech-republic',
//            'greece',
//            'india',
//            'pakistan',
//            'switzerland',
//            'ireland',
//            'venezuela',
//            'mexico',
//            'belgium',
//            'china',
//            'croatia',
//            'cyprus',
//            'austria',
        ];

        foreach ($clubCountries as $clubCountry) {
            $this->command->info('#######################');
            $this->command->info('Loading: '. $clubCountry);
            $this->command->info('#######################');

            $clubs = $this->collectClubs(
                database_path('data/'.$clubCountry.'_teams.json')
            );

            $clubs->each(function (array $data) {
                /** @var Club $club */
//                $data['team']['country'] = Country::where('name', $data['team']['country'])->first()->name;

                $club = Club::create(collect($data['team'])->only('name', 'country')->toArray());

                $this->command->info('Loading club: '. $club->name);

                if (array_key_exists('logo', $data['team'])) {
                    try {
                        $club->addMediaFromUrl($data['team']['logo'])->toMediaCollection('logo');
                    } catch (\Exception $e) {
                        Log::info($e->getMessage());
                    }
                }
            });
        }

        Schema::enableForeignKeyConstraints();
    }

    /**
     * @param  string  $clubsFile
     * @return \Illuminate\Support\Collection
     */
    private function collectClubs(string $clubsFile): Collection
    {
        return collect(json_decode(file_get_contents($clubsFile), true));
    }
}
