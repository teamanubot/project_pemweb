<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\PaymentTransaction;

class MidtransController extends Controller
{
    public function form()
    {
        return view('register');
    }

    public function token(Request $request)
    {
        if (User::where('email', $request->email)->exists()) {
            return response()->json([
                'error' => 'Email sudah digunakan. Silakan pakai email lain.'
            ], 409);
        }

        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $orderId = 'DEMO-' . uniqid();

        $course = \App\Models\Course::where('is_active', true)->find($request->course_id);
        if (!$course) {
            return response()->json(['error' => 'Course tidak ditemukan'], 404);
        }

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $course->price,
            ],
            'customer_details' => [
                'first_name' => $request->nama_depan,
                'last_name' => $request->nama_belakang,
                'email' => $request->email,
                'phone' => $request->phone_number,
            ]
        ];

        $snapToken = Snap::getSnapToken($params);

        return response()->json(['token' => $snapToken]);
    }

    public function handleSuccess(Request $request)
    {
        $result = $request->all();

        $studentRole = Role::where('name', 'student')->where('guard_name', 'student')->first();

        $fullName = $request->nama_depan . ' ' . $request->nama_belakang;

        $student = User::firstOrCreate(
            ['email' => $request->email],
            [
                'name'              => $fullName,
                'avatar_url'        => null,
                'email_verified_at' => now(),
                'password'          => Hash::make($request->password),
                'remember_token'    => Str::random(10),
                'phone_number'      => $request->phone_number,
                'address'           => $request->address,
                'nik'               => $request->nik,
                'job_title'         => 'Student',
                'department_id'     => null,
                'employment_status' => null,
                'onboarding_date'   => now()->toDateString(),
                'expertise_area'    => 'Web Development',
                'teaching_status'   => null,
            ]
        );

        if ($studentRole) {
            $student->roles()->syncWithoutDetaching([$studentRole->id]);
        }

        // Ambil course
        $course = Course::where('is_active', true)->find($request->course_id);
        if (!$course) {
            return response()->json(['error' => 'Course tidak ditemukan'], 404);
        }

        // Enroll student ke course
        $enrollment = CourseEnrollment::firstOrCreate(
            ['user_id' => $student->id, 'course_id' => $course->id],
            [
                'enrollment_date' => now(),
                'payment_status' => 'paid',
                'access_granted_at' => now(),
                'is_completed' => false
            ]
        );

        // Simpan transaksi pembayaran
        $result = $request->midtrans_result;

        PaymentTransaction::create([
            'course_enrollment_id'   => $enrollment->id,
            'midtrans_order_id'      => $result['order_id'] ?? null,
            'midtrans_transaction_id' => $result['transaction_id'] ?? null,
            'amount'                 => $course->price,
            'currency'               => 'IDR',
            'payment_method'         => $result['payment_type'] ?? null,
            'transaction_status'     => $result['transaction_status'] ?? 'unknown',
            'transaction_time'       => $result['transaction_time'] ?? now(),
            'settlement_time'        => now(),
            'expiry_time'            => now()->addDays(1),
            'raw_response'           => json_encode($result),
        ]);

        return response()->json(['status' => 'success']);
    }
}
