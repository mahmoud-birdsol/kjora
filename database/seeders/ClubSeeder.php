<?php

namespace Database\Seeders;

use App\Models\Club;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
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

        $file = fopen(database_path("data/league_ids.csv"), "r");
        $leagues = [];
        while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
            $leagues[] = [
                'country' => $data[0],
                'league_id' => $data[1],
            ];
        }
        fclose($file);

        foreach ($leagues as $league) {
            $this->command->info('#######################');
            $this->command->info('Loading: ' . $league['country']);
            $this->command->info('#######################');

            $response = Http::withHeaders([
                'x-rapidapi-host' => 'v3.football.api-sports.io',
                'x-rapidapi-key' => '303758e6ae860e914bb0755664b4caf0',
            ])->get('https://v3.football.api-sports.io/teams?country=' . $league['country'] . '&league=' . $league['league_id'] . '&season=2022');

            $clubs = collect(json_decode($response->body(), true)['response']);

            $clubs->each(function (array $data) {
                $club = Club::create(collect($data['team'])->only('name', 'country')->toArray());

                $this->command->info('Loading club: ' . $club->name);

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
     * @param string $clubsFile
     * @return \Illuminate\Support\Collection
     */
    private function collectClubs(string $clubsFile): Collection
    {
        return collect(json_decode(file_get_contents($clubsFile), true));
    }
}
