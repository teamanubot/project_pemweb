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
use App\Mail\InvoiceMidtrans;
use Illuminate\Support\Facades\Mail;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Session;

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

        $orderId = 'UEU Bootcamp MID-' . uniqid();

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

        $otpInput = $request->input('otp');
        $savedOtp = Session::pull('otp_code'); // Sekali pakai: ambil lalu hapus dari session
        $otpExpired = Session::pull('otp_expired'); // Sekali pakai

        if (!$savedOtp || !$otpExpired || now()->greaterThan($otpExpired) || $otpInput != $savedOtp) {
            return response()->json(['error' => 'Kode OTP salah atau kedaluwarsa.'], 422);
        }


        $snapToken = Snap::getSnapToken($params);

        return response()->json(['token' => $snapToken]);
    }

    public function handleSuccess(Request $request)
    {
        $result = $request->all();

        $midtransResponse = $request->midtrans_result ?? $result;

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

        $paymentTransaction = PaymentTransaction::create([
            'user_id'                => $student->id,
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

        $sendInvoiceTo = $request->input('send_invoice_to');

        // Hanya kirim kalau email tidak kosong dan berakhiran @gmail.com
        if ($sendInvoiceTo && str_ends_with($sendInvoiceTo, '@gmail.com')) {
            try {
                Mail::to($sendInvoiceTo)->send(new InvoiceMidtrans($paymentTransaction, $student, $course));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Gagal kirim invoice ke custom email: ' . $e->getMessage());
            }
        }

        return response()->json(['status' => 'success']);
    }

    public function generateOtp(Request $request)
    {
        if (Session::has('otp_code') && now()->lessThan(Session::get('otp_expired'))) {
            return response()->json(['error' => 'OTP sebelumnya masih berlaku. Silakan gunakan OTP yang sudah dikirim.'], 429);
        }
        
        $phone = $request->input('phone_number');

        if (!$phone) {
            return response()->json(['error' => 'Nomor HP wajib diisi'], 422);
        }

        // Normalisasi nomor ke format internasional
        $phone = preg_replace('/\D/', '', $phone); // Hapus semua non-digit

        if (str_starts_with($phone, '62')) {
            $normalizedPhone = '+' . $phone;
        } elseif (str_starts_with($phone, '08')) {
            $normalizedPhone = '+62' . substr($phone, 1);
        } elseif (str_starts_with($phone, '+62')) {
            $normalizedPhone = $phone;
        } else {
            return response()->json(['error' => 'Format nomor tidak valid. Gunakan 08xxxx atau +628xxxx'], 422);
        }


        $otp = rand(100000, 999999);
        Session::put('otp_code', $otp);
        Session::put('otp_expired', now()->addMinutes(5));

        try {
            $sid = config('services.twilio.sid');
            $token = config('services.twilio.token');
            $from = config('services.twilio.whatsapp_from');

            $twilio = new Client($sid, $token);

            $twilio->messages->create("whatsapp:{$normalizedPhone}", [
                "from" => "whatsapp:{$from}",
                "body" => "Kode verifikasi OTP Anda adalah: {$otp}. Berlaku selama 5 menit."
            ]);

            return response()->json(['message' => 'OTP berhasil dikirim ke WhatsApp.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal mengirim OTP: ' . $e->getMessage()], 500);
        }
    }
}
