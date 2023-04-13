<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        $positions = [
//            'Forward',
//            'Midfielder',
//            'Defender',
//            'Goalkeeper',
//        ];
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
//
//        foreach ($positions as $position) {
//            Position::create([
//                'name' => $position,
//            ]);
//        }
    }
}
