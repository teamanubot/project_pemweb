<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PaymentTransaction;
use App\Models\CourseEnrollment;

class PaymentTransactionsTableSeeder extends Seeder
{
    public function run()
    {
        PaymentTransaction::create([
            'course_enrollment_id' => CourseEnrollment::first()->id,
            'midtrans_order_id' => 'MID-ORD-1234',
            'midtrans_transaction_id' => 'MID-TRANS-5678',
            'amount' => 1500000,
            'currency' => 'IDR',
            'payment_method' => 'bank_transfer',
            'transaction_status' => 'settlement',
            'transaction_time' => now(),
            'settlement_time' => now(),
            'expiry_time' => now()->addDays(1),
            'raw_response' => json_encode(['status' => 'ok'])
        ]);
    }
}
