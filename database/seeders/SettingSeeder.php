<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::updateOrCreate(
            ['id' => 1],
            [
                'accreditation_start_time' => now()->subDays(7),
                'accreditation_end_time' => now()->addDays(14),
            ]
        );
    }
}
