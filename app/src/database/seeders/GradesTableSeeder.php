<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Grade;
use App\Models\User;
use App\Models\Course;

class GradesTableSeeder extends Seeder
{
    public function run()
    {
        Grade::create([
            'user_id' => User::first()->id,
            'course_id' => Course::first()->id,
            'quiz_assignment_score' => 95,
            'attendance_percentage' => 100,
            'mid_eval_score' => 88,
            'final_eval_score' => 90,
            'project_score' => 92,
            'final_grade' => 91,
            'is_passed' => true,
            'graded_at' => now()
        ]);
    }
}
