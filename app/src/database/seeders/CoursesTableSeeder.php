<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;

class CoursesTableSeeder extends Seeder
{
    public function run()
    {
        Course::create([
            'name' => 'Web Development',
            'description' => 'Belajar membuat web modern',
            'duration_months' => 3,
            'total_sessions' => 12,
            'price' => 1500000,
            'is_active' => true
        ]);
    }
}

