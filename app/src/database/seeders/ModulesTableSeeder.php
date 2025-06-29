<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Module;
use App\Models\Sesi;
use App\Models\User;

class ModulesTableSeeder extends Seeder
{
    public function run()
    {
        Module::create([
            'sesi_id' => Sesi::first()->id,
            'title' => 'Intro HTML',
            'file_path' => 'modules/html-intro.pdf',
            'file_type' => 'pdf',
            'link_url' => null,
            'description' => 'Dasar HTML',
            'uploaded_by_user_id' => User::first()->id,
            'is_verified' => true
        ]);
    }
}
