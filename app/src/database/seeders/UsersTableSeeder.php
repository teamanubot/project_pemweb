<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

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
            ]
        );

        // Instructor (Teacher)
        $instructorRole = Role::where('name', 'teacher')->where('guard_name', 'instructor')->first();

        for ($i = 1; $i <= 10; $i++) {
            $firstName = $faker->firstName;
            $lastName = $faker->lastName;

            // Nama untuk tampilan, ditambah gelar
            $name = "$firstName $lastName, S.Kom., M.Kom";

            // Email tetap rapi, tidak ada gelar
            $username = Str::slug("$firstName $lastName", '.');
            $email = $username . '@instructor.bootcamp.com';

            $instructor = User::firstOrCreate(
                ['email' => $email],
                [
                    'name'              => $name,
                    'avatar_url'        => null,
                    'email_verified_at' => now(),
                    'password'          => Hash::make('password'), // default password
                    'remember_token'    => Str::random(10),
                    'phone_number'      => $faker->phoneNumber,
                    'address'           => $faker->address,
                    'nik'               => $faker->unique()->numerify('327601##########'),
                    'job_title'         => 'Teacher',
                    'department_id'     => null,
                    'employment_status' => null,
                    'onboarding_date'   => now()->toDateString(),
                    'expertise_area'    => 'Web Development',
                    'teaching_status'   => null,
                ]
            );

            if ($instructorRole) {
                $instructor->roles()->syncWithoutDetaching([$instructorRole->id]);
            }
        }

        // Student
        $studentRole = Role::where('name', 'student')->where('guard_name', 'student')->first();

        for ($i = 1; $i <= 10; $i++) {
            $firstName = $faker->firstName;
            $lastName = $faker->lastName;
            $name = "$firstName $lastName";

            $username = Str::slug($name, '.');
            $email = $username . '@student.bootcamp.com';

            $student = User::firstOrCreate(
                ['email' => $email],
                [
                    'name'              => $name,
                    'avatar_url'        => null,
                    'email_verified_at' => now(),
                    'password'          => Hash::make('password'), // default password
                    'remember_token'    => Str::random(10),
                    'phone_number'      => $faker->phoneNumber,
                    'address'           => $faker->address,
                    'nik'               => $faker->unique()->numerify('327601##########'),
                    'job_title'         => 'Student',
                    'department_id'     => null,
                    'employment_status' => null,
                    'onboarding_date'   => now()->toDateString(),
                    'expertise_area'    => 'Web Development',
                    'teaching_status'   => null,
                ]
            );

            if ($studentRole) {
                $student->roles()->syncWithoutDetaching([$studentRole->id]);
            }
        }

        $super_adminRole = Role::where('name', 'super_admin')->where('guard_name', 'admin')->first();
        if ($super_adminRole) {
            $super_admin->roles()->attach($super_adminRole); // assign role langsung
        }

        $adminCompanyRole = Role::where('name', 'admin_company')->where('guard_name', 'admin')->first();
        if ($adminCompanyRole) {
            $adminCompany->roles()->attach($adminCompanyRole); // assign role langsung
        }

        $adminLMSRole = Role::where('name', 'admin_lms')->where('guard_name', 'admin')->first();
        if ($adminLMSRole) {
            $adminLMS->roles()->attach($adminLMSRole); // assign role langsung
        }

        $adminHRMRole = Role::where('name', 'admin_hrm')->where('guard_name', 'admin')->first();
        if ($adminHRMRole) {
            $adminHRM->roles()->attach($adminHRMRole); // assign role langsung
        }

        $adminHRRole = Role::where('name', 'admin_hr')->where('guard_name', 'admin')->first();
        if ($adminHRRole) {
            $adminHR->roles()->attach($adminHRRole); // assign role langsung
        }

        $adminAkademikRole = Role::where('name', 'admin_akademik')->where('guard_name', 'admin')->first();
        if ($adminAkademikRole) {
            $adminAkademik->roles()->attach($adminAkademikRole); // assign role langsung
        }
    }
}
