<?php

namespace Database\Seeders;

use App\Models\Position;
use App\Models\RatingCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TranslatedRatingCategory extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ratingCategories = [
            [
                'en' => 'Pace',
                'ar' => 'نمط'
            ],
            [
                'en' => 'Shooting',
                'ar' => 'تسديد'
            ],
            [
                'en' => 'Passing',
                'ar' => 'تمرير'
            ],
            [
                'en' => 'Dribbling',
                'ar' => 'مراوغة'
            ],
            [
                'en' => 'Defending',
                'ar' => 'دفاع'
            ],
            [
                'en' => 'Physical',
                'ar' => 'بدني'
            ],
            [
                'en' => 'Diving',
                'ar' => 'القفز'
            ],
            [
                'en' => 'Reflexes',
                'ar' => 'رد الفعل'
            ],
            [
                'en' => 'Handling',
                'ar' => 'تحكم'
            ],
            [
                'en' => 'Speed',
                'ar' => 'سرعة'
            ],
            [
                'en' => 'Kicking',
                'ar' => 'ركل'
            ],
            [
                'en' => 'Positioning',
                'ar' => 'تمركز'
            ],
        ];


        $translatedRatingCategories = RatingCategory::all();
    }
}
