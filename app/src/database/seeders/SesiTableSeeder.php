<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sesi;
use App\Models\Course;
use App\Models\User;
use App\Models\Syllabus;
use Carbon\Carbon;

class SesiTableSeeder extends Seeder
{
    public function run()
    {
        Sesi::create([
            'course_id' => Course::first()->id,
            'teacher_id' => User::first()->id,
            'session_number' => 1,
            'session_type' => 'theory',
            'delivery_method' => 'online',
            'session_date' => Carbon::tomorrow(),
            'start_time' => '09:00:00',
            'end_time' => '11:00:00',
            'online_link' => 'https://zoom.com/abcd',
            'syllabus_id' => Syllabus::first()->id,
            'status' => 'scheduled'
        ]);
    }
}
