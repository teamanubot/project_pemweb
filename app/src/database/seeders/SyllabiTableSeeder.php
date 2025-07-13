<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Syllabus;
use App\Models\Course;
use App\Models\User;

class SyllabiTableSeeder extends Seeder
{
    public function run()
    {
        Syllabus::create([
            'course_id' => Course::first()->id,
            'title' => 'HTML & CSS Dasar',
            'description' => 'Materi pertama',
            'file_path' => 'syllabus/html-css.pdf',
            'is_verified' => true,
            'verified_by_user_id' => User::first()->id
        ]);
    }
}
