<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PayrollSetting;

class PayrollSettingsTableSeeder extends Seeder
{
    public function run()
    {
        PayrollSetting::create([
            'setting_key' => 'gaji_pokok_teacher',
            'setting_value' => '5000000',
            'applies_to_role' => 'teacher'
        ]);
    }
}
