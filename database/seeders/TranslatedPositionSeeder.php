<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TranslatedPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $positions = [
            [
                'en' => 'Forward',
                'ar' => 'مهاجم'
            ],
            [
                'en' => 'Midfielder',
                'ar' => 'خط وسط'
            ],
            [
                'en' => 'Defender',
                'ar' => 'مدافع'
            ],
            [
                'en' => 'Goalkeeper',
                'ar' => 'حارس مرمى'
            ],
        ];

        $currentPositions = Position::all();

        foreach ($currentPositions as $index => $currentPosition) {
            $currentPosition->update([
                'name' => $positions[$index]
            ]);

        }
    }
}
