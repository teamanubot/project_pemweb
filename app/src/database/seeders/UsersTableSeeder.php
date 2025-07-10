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
        $super_admin = User::firstOrCreate(
            ['email' => 'admin@bootcamp.com'],
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
                'department_id' => 2,
                'employment_status' => 'active',
                'onboarding_date' => now()->toDateString(),
                'expertise_area' => 'Admin Management',
                'teaching_status'   => 'inactive',
                'role' => 'super_admin',
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

        // Admin Company
        $adminCompany = User::firstOrCreate(
            ['email' => 'admincompany@bootcamp.com'],
            [
                'name' => 'Bootcamp Admin',
                'avatar_url'        => null,
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'phone_number' => '081212121212',
                'address' => 'Bandung',
                'nik' => '3276010101010002',
                'job_title' => 'Instructor',
                'department_id' => 2,
                'employment_status' => 'active',
                'onboarding_date' => now()->toDateString(),
                'expertise_area' => 'Web Development',
                'teaching_status' => 'inactive',
                'role' => 'admin_company',
                'remember_token' => Str::random(10),
            ]
        );

        // Admin HRM
        $adminHRM = User::firstOrCreate(
            ['email' => 'adminhrm@bootcamp.com'],
            [
                'name' => 'HRM Admin',
                'avatar_url' => null,
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'phone_number' => '081212121213',
                'address' => 'Bandung',
                'nik' => '3276010101010003',
                'job_title' => 'HR Manager',
                'department_id' => 2,
                'employment_status' => 'active',
                'onboarding_date' => now()->toDateString(),
                'expertise_area' => 'Human Resource Management',
                'teaching_status' => 'inactive',
                'role' => 'admin_hrm',
            ]
        );

        // Admin LMS
        $adminLMS = User::firstOrCreate(
            ['email' => 'adminlms@bootcamp.com'],
            [
                'name' => 'LMS Admin',
                'avatar_url' => null,
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'phone_number' => '081212121214',
                'address' => 'Bandung',
                'nik' => '3276010101010004',
                'job_title' => 'LMS Administrator',
                'department_id' => 2,
                'employment_status' => 'active',
                'onboarding_date' => now()->toDateString(),
                'expertise_area' => 'Learning Management',
                'teaching_status' => 'inactive',
                'role' => 'admin_lms',
            ]
        );

        // Admin Akademik
        $adminAkademik = User::firstOrCreate(
            ['email' => 'adminakademik@bootcamp.com'],
            [
                'name' => 'Akademik Admin',
                'avatar_url' => null,
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'phone_number' => '081212121215',
                'address' => 'Bandung',
                'nik' => '3276010101010005',
                'job_title' => 'Academic Manager',
                'department_id' => 1,
                'employment_status' => 'active',
                'onboarding_date' => now()->toDateString(),
                'expertise_area' => 'Education',
                'teaching_status' => 'inactive',
                'role' => 'admin_akademik',
            ]
        );

        // Admin HR
        $adminHR = User::firstOrCreate(
            ['email' => 'adminhr@bootcamp.com'],
            [
                'name' => 'HR Admin',
                'avatar_url' => null,
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'phone_number' => '081212121216',
                'address' => 'Bandung',
                'nik' => '3276010101010006',
                'job_title' => 'HR Officer',
                'department_id' => 2,
                'employment_status' => 'active',
                'onboarding_date' => now()->toDateString(),
                'expertise_area' => 'HR',
                'teaching_status' => 'inactive',
                'role' => 'admin_hr',
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
                'department_id' => 3,
                'employment_status' => 'active',
                'onboarding_date' => now()->toDateString(),
                'expertise_area' => 'Web Development',
                'teaching_status' => 'inactive',
                'role' => 'student',
                'remember_token' => Str::random(10),
            ]
        );

        $super_adminRole = Role::where('name', 'adminsuper')->where('guard_name', 'web')->first();
        if ($super_adminRole) {
            $super_admin->roles()->attach($super_adminRole); // assign role langsung
        }

        $adminCompanyRole = Role::where('name', 'admin_company')->where('guard_name', 'web')->first();
        if ($adminCompanyRole) {
            $adminCompany->roles()->attach($adminCompanyRole); // assign role langsung
        }

        $adminLMSRole = Role::where('name', 'admin_lms')->where('guard_name', 'web')->first();
        if ($adminLMSRole) {
            $adminLMS->roles()->attach($adminLMSRole); // assign role langsung
        }

        $adminHRMRole = Role::where('name', 'admin_hrm')->where('guard_name', 'web')->first();
        if ($adminHRMRole) {
            $adminHRM->roles()->attach($adminHRMRole); // assign role langsung
        }

        $adminHRRole = Role::where('name', 'admin_hr')->where('guard_name', 'web')->first();
        if ($adminHRRole) {
            $adminHR->roles()->attach($adminHRRole); // assign role langsung
        }

        $adminAkademikRole = Role::where('name', 'admin_akademik')->where('guard_name', 'web')->first();
        if ($adminAkademikRole) {
            $adminAkademik->roles()->attach($adminAkademikRole); // assign role langsung
        }

        $instructorRole = Role::where('name', 'teacher')->where('guard_name', 'instructor')->first();
        if ($instructorRole) {
            $instructor->roles()->attach($instructorRole); // assign role langsung
        }

        $studentRole = Role::where('name', 'student')->where('guard_name', 'student')->first();
        if ($studentRole) {
            $student->roles()->attach($studentRole); // assign role langsung
        }
    }
}
