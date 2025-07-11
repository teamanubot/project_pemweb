<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;

class CoursesTableSeeder extends Seeder
{
    public function run()
    {
        $courses = [
            [
                'name' => 'Web Development',
                'description' => 'Belajar membuat web modern dengan HTML, CSS, JavaScript dan Laravel',
                'duration_months' => 6,
                'total_sessions' => 72,
                'price' => 15000000,
                'is_active' => true,
            ],
            [
                'name' => 'Mobile App Development',
                'description' => 'Membuat aplikasi Android dan iOS dengan Flutter',
                'duration_months' => 5,
                'total_sessions' => 60,
                'price' => 18000000,
                'is_active' => false,
            ],
            [
                'name' => 'UI/UX Design',
                'description' => 'Desain antarmuka pengguna yang menarik dan ramah pengguna',
                'duration_months' => 3,
                'total_sessions' => 36,
                'price' => 12000000,
                'is_active' => false,
            ],
        ];

        foreach ($courses as $course) {
            Course::create($course);
        }
    }
}