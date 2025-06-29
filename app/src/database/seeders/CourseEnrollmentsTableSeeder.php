<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CourseEnrollment;
use App\Models\User;
use App\Models\Course;

class CourseEnrollmentsTableSeeder extends Seeder
{
    public function run()
    {
        $user = User::first();
        $course = Course::first();

        CourseEnrollment::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'enrollment_date' => now(),
            'payment_status' => 'paid',
            'access_granted_at' => now(),
            'is_completed' => false
        ]);
    }
}
