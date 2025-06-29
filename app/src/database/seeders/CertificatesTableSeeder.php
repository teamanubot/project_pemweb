<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Certificate;
use App\Models\User;
use App\Models\Course;

class CertificatesTableSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first(); // ambil user pertama
        $course = Course::first(); // ambil course pertama

        Certificate::firstOrCreate(
            [
                'user_id' => $user->id,
                'course_id' => $course->id,
            ],
            [
                'certificate_number' => 'CERT-' . now()->format('YmdHis') . '-' . rand(100, 999),
                'issue_date' => now()->toDateString(),
                'qr_code_url' => 'https://example.com/qrcode.png',
                'file_path' => 'certificates/cert-' . now()->format('YmdHis') . '.pdf',
                'signed_by_user_id' => $user->id,
            ]
        );
    }
}
