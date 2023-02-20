<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Rating;
use App\Models\Stadium;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            AdminSeeder::class,
            PositionSeeder::class,
            CountrySeeder::class,
            ClubSeeder::class,
        ]);

        for ($i = 1; $i <= 5; $i++) {
            Rating::factory()->create([
                'rating_from' => $i,
                'rating_to' => $i + 1,
                'hourly_rate' => $i * 10,
            ]);
        }

        Stadium::factory()->count(10)->create();
    }
}
