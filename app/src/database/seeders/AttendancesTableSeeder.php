<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attendance;
use App\Models\Sesi;
use App\Models\User;

class AttendancesTableSeeder extends Seeder
{
    public function run()
    {
        Attendance::create([
            'user_id' => User::first()->id,
            'sesi_id' => Sesi::first()->id,
            'attendance_date' => now()->toDateString(),
            'clock_in_time' => now(),
            'clock_out_time' => now()->addHours(2),
            'status' => 'present',
            'proof_file_path' => null,
            'notes' => null,
            'verified_by_user_id' => User::first()->id,
            'verified_at' => now()
        ]);
    }
}
