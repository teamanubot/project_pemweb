<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Leave;
use App\Models\User;

class LeavesTableSeeder extends Seeder
{
    public function run()
    {
        Leave::create([
            'user_id' => User::first()->id,
            'leave_type' => 'sick',
            'start_date' => now()->addDays(5),
            'end_date' => now()->addDays(6),
            'number_of_days' => 1,
            'reason' => 'Demam',
            'proof_file_path' => null,
            'status' => 'approved',
            'approved_by_user_id' => User::first()->id,
            'approved_at' => now(),
            'replacement_user_id' => null
        ]);
    }
}
