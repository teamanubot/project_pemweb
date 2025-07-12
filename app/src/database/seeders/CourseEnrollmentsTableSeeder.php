<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CourseEnrollment;
use App\Models\User;
use App\Models\Course;

class CourseEnrollmentsTableSeeder extends Seeder
{
    public function run(): void
    {
        $course = Course::find(1); // ambil course id 1

        if (!$course) {
            $this->command->error('Course ID 1 tidak ditemukan.');
            return;
        }

        // Ambil semua user yang punya role student (dengan guard student)
        $students = User::whereHas('roles', function ($query) {
            $query->where('name', 'student')
                  ->where('guard_name', 'student');
        })->get();

        foreach ($students as $student) {
            CourseEnrollment::firstOrCreate([
                'user_id' => $student->id,
                'course_id' => $course->id,
            ], [
                'enrollment_date' => now(),
                'payment_status' => 'paid',
                'access_granted_at' => now(),
                'is_completed' => false
            ]);
        }
    }
}