<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentTransaction;
use App\Models\CourseEnrollment;

class PaymentTransactionsTableSeeder extends Seeder
{
    public function run()
    {
        $enrollments = CourseEnrollment::with('course')->get();

        foreach ($enrollments as $index => $enrollment) {
            $course = $enrollment->course;

            if (!$course || !$enrollment->user_id) {
                continue; // Lewati jika tidak ada relasi course atau user
            }

            PaymentTransaction::create([
                'user_id'                  => $enrollment->user_id,
                'course_enrollment_id'     => $enrollment->id,
                'midtrans_order_id'        => 'MID-ORD-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                'midtrans_transaction_id'  => 'MID-TRANS-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                'amount'                   => $course->price,
                'currency'                 => 'IDR',
                'payment_method'           => 'bank_transfer',
                'transaction_status'       => 'settlement',
                'transaction_time'         => now(),
                'settlement_time'          => now(),
                'expiry_time'              => now()->addDays(1),
                'raw_response'             => json_encode([
                    'status' => 'ok',
                    'course' => $course->name,
                    'user_id' => $enrollment->user_id,
                ]),
            ]);
        }
    }
}