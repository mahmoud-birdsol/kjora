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
                'ar' => 'حارس مرمي'
            ],
        ];

        foreach ($positions as $position) {
            Position::create([
                'name' => [
                    'en' => $position['en'],
                    'ar' => $position['ar'],
                ],
            ]);
        }
    }
}
