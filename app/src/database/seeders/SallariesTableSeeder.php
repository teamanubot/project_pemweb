<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Sallary;
use App\Models\User;

class SallariesTableSeeder extends Seeder
{
    public function run()
    {
        Sallary::create([
            'user_id' => User::first()->id,
            'month' => now()->month,
            'year' => now()->year,
            'base_salary' => 5000000,
            'overtime_pay' => 500000,
            'alpha_deduction' => 0,
            'excess_leave_deduction' => 0,
            'total_gross_salary' => 5500000,
            'total_net_salary' => 5500000,
            'generated_at' => now(),
            'generated_by_user_id' => User::first()->id
        ]);
    }
}
