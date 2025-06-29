<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Jalankan seeder department dulu agar department_id 1 tersedia
        $this->call(DepartmentsTableSeeder::class);

        // Buat Super Admin
        $user = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Super Admin',
                'avatar_url' => null,
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'phone_number' => '081234567890',
                'address' => 'Citra Raya',
                'nik' => '3276010101010001',
                'job_title' => 'Founder',
                'department_id' => 1, // Sekarang sudah aman karena department sudah dibuat
                'employment_status' => 'active',
                'onboarding_date' => now()->toDateString(),
                'expertise_area' => 'Management',
                'teaching_status' => 'inactive',
                'role' => 'admin_company',
                'remember_token' => Str::random(10),
            ]
        );

        // Tambahkan role super_admin jika pakai Spatie
        if (\Spatie\Permission\Models\Role::where('name', 'super_admin')->exists()) {
            $user->assignRole('super_admin');
        }

        // Jalankan semua seeder lainnya
        $this->call([
            UsersTableSeeder::class,
            CoursesTableSeeder::class,
            CourseEnrollmentsTableSeeder::class,
            SyllabiTableSeeder::class,
            SesiTableSeeder::class,
            ModulesTableSeeder::class,
            QuizzesTableSeeder::class,
            SubmissionsTableSeeder::class,
            GradesTableSeeder::class,
            AttendancesTableSeeder::class,
            LeavesTableSeeder::class,
            SallariesTableSeeder::class,
            PayrollSettingsTableSeeder::class,
            CertificatesTableSeeder::class,
            SystemNotificationsTableSeeder::class,
            CompanyProfileSettingsTableSeeder::class,
            BlogPostsTableSeeder::class,
            PaymentTransactionsTableSeeder::class,
        ]);
    }
}
