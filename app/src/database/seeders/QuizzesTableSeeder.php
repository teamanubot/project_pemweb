<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Quiz;
use App\Models\Sesi;
use App\Models\Course;
use App\Models\User;

class QuizzesTableSeeder extends Seeder
{
    public function run()
    {
        Quiz::create([
            'sesi_id' => Sesi::first()->id,
            'course_id' => Course::first()->id,
            'title' => 'Quiz HTML',
            'description' => 'Tes awal',
            'type' => 'quiz',
            'due_date' => now()->addDays(3),
            'max_score' => 100,
            'created_by_user_id' => User::first()->id
        ]);
    }
}
