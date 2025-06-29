<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Super Admin',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'phone_number' => '081234567890',
                'address' => 'Citra Raya',
                'nik' => '3276010101010001',
                'job_title' => 'Super Admin',
                'department_id' => 1,
                'employment_status' => 'active',
                'onboarding_date' => now(),
                'role' => 'admin_company'
            ]
        );
    }
}
