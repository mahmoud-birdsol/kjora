<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mahmoud = Admin::factory()->create([
            'name' => 'Mahmoud El-Mokhtar',
            'email' => 'mahmoud@birdsol.com',
        ]);

        $mahmoud->assignRole('developer');

        $najat = Admin::factory()->create([
            'name' => 'Najat Alsharidah',
            'email' => 'najat@kjora.com',
        ]);

        $najat->assignRole('super admin');

        $ahmed = Admin::factory()->create([
            'name' => 'Ahmed Alsharidah',
            'email' => 'ahmed@kjora.com',
        ]);

        $ahmed->assignRole('super admin');
    }
}
