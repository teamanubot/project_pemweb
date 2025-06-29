<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CompanyProfileSetting;

class CompanyProfileSettingsTableSeeder extends Seeder
{
    public function run()
    {
        CompanyProfileSetting::create([
            'setting_key' => 'nama_perusahaan',
            'setting_value' => 'PT Edu Tech Indonesia'
        ]);
    }
}
