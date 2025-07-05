<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Super Admin',
                'avatar_url'        => null,
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'phone_number' => '081234567890',
                'address' => 'Citra Raya',
                'nik' => '3276010101010001',
                'job_title' => 'Founder',
                'department_id' => 1,
                'employment_status' => 'active',
                'onboarding_date' => now()->toDateString(),
                'expertise_area' => 'Management',
                'teaching_status'   => 'inactive',
                'role' => 'admin_company',
                'remember_token' => Str::random(10),
            ]
        );

        // Instructor (Teacher)
        $instructor = User::firstOrCreate(
            ['email' => 'instructor@bootcamp.com'],
            [
                'name' => 'Bootcamp Instructor',
                'avatar_url'        => null,
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'phone_number' => '081212121212',
                'address' => 'Bandung',
                'nik' => '3276010101010002',
                'job_title' => 'Instructor',
                'department_id' => 1,
                'employment_status' => 'active',
                'onboarding_date' => now()->toDateString(),
                'expertise_area' => 'Web Development',
                'teaching_status' => 'active',
                'role' => 'teacher',
                'remember_token' => Str::random(10),
            ]
        );

        // Student
        $student = User::firstOrCreate(
            ['email' => 'student@bootcamp.com'],
            [
                'name' => 'Bootcamp Student',
                'avatar_url' => null,
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'phone_number' => '081313131313',
                'address' => 'Jakarta',
                'nik' => '3276010101010003',
                'job_title' => 'Student',
                'department_id' => 1,
                'employment_status' => 'active',
                'onboarding_date' => now()->toDateString(),
                'expertise_area' => 'Web Development',
                'teaching_status' => 'inactive',
                'role' => 'student',
                'remember_token' => Str::random(10),
            ]
        );

        $adminRole = Role::where('name', 'admin_company')->where('guard_name', 'admin')->first();
        if ($adminRole) {
            $admin->roles()->attach($adminRole); // assign role langsung
        }

        $instructorRole = Role::where('name', 'teacher')->where('guard_name', 'instructor')->first();
        if ($instructorRole) {
            $instructor->roles()->attach($instructorRole); // assign role langsung
        }
    }
}
