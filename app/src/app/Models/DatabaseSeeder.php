<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seeder penting yang harus jalan dulu
        $this->call([
            BranchOfficesTableSeeder::class,
            DepartmentsTableSeeder::class,
        ]);

        // Seeder tambahan (data pelengkap)
        $this->call([
            RoleSeeder::class,
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