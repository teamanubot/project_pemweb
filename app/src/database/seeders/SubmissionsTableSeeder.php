<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Submission;
use App\Models\Quiz;
use App\Models\User;

class SubmissionsTableSeeder extends Seeder
{
    public function run()
    {
        Submission::create([
            'quiz_id' => Quiz::first()->id,
            'user_id' => User::first()->id,
            'submitted_at' => now(),
            'text_answer' => 'Jawaban quiz',
            'score' => 95,
            'feedback' => 'Bagus',
            'graded_by_user_id' => User::first()->id,
            'graded_at' => now()
        ]);
    }
}
