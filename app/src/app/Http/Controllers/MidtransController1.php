<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
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

        $course = Course::where('is_active', true)->find($request->course_id);
        if (!$course) {
            return response()->json(['error' => 'Course tidak ditemukan'], 404);
        }

        // Kirim kode OTP via WhatsApp
        try {
            $fullName = $request->nama_depan . ' ' . $request->nama_belakang;
            $verificationCode = rand(100000, 999999);

            // Simpan ke Cache untuk 5 menit
            Cache::put('otp_' . $request->email, $verificationCode, now()->addMinutes(5));

            app(WhatsAppController::class)->sendWhatsAppMessage(new Request([
                'recipient_number' => $this->formatToWhatsApp($request->phone_number),
                'message' => "Halo {$fullName}, kode verifikasi Anda adalah *{$verificationCode}*. Gunakan kode ini untuk melanjutkan pendaftaran di UEU Bootcamp."
            ]));
        } catch (\Exception $e) {
            \Log::error('Gagal kirim WhatsApp OTP: ' . $e->getMessage());
        }

        // Buat Snap Token
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

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp'   => 'required|digits:6'
        ]);

        $cached = Cache::get('otp_' . $request->email);

        if ($cached && $cached == $request->otp) {
            return response()->json(['status' => 'valid', 'message' => 'OTP sesuai']);
        }

        return response()->json(['status' => 'invalid', 'message' => 'OTP salah atau kedaluwarsa'], 400);
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

        $course = Course::where('is_active', true)->find($request->course_id);
        if (!$course) {
            return response()->json(['error' => 'Course tidak ditemukan'], 404);
        }

        $enrollment = CourseEnrollment::firstOrCreate(
            ['user_id' => $student->id, 'course_id' => $course->id],
            [
                'enrollment_date' => now(),
                'payment_status' => 'paid',
                'access_granted_at' => now(),
                'is_completed' => false
            ]
        );

        $result = $request->midtrans_result;

        PaymentTransaction::create([
            'course_enrollment_id'    => $enrollment->id,
            'midtrans_order_id'       => $result['order_id'] ?? null,
            'midtrans_transaction_id' => $result['transaction_id'] ?? null,
            'amount'                  => $course->price,
            'currency'                => 'IDR',
            'payment_method'          => $result['payment_type'] ?? null,
            'transaction_status'      => $result['transaction_status'] ?? 'unknown',
            'transaction_time'        => $result['transaction_time'] ?? now(),
            'settlement_time'         => now(),
            'expiry_time'             => now()->addDays(1),
            'raw_response'            => json_encode($result),
        ]);

        // Kirim WA pemberitahuan
        try {
            app(WhatsAppController::class)->sendWhatsAppMessage(new Request([
                'recipient_number' => $this->formatToWhatsApp($request->phone_number),
                'message' => "Halo {$fullName}, pembayaran Anda untuk course \"{$course->name}\" telah berhasil. Selamat belajar di UEU Bootcamp!"
            ]));
        } catch (\Exception $e) {
            \Log::error('Gagal kirim WA setelah pembayaran: ' . $e->getMessage());
        }

        return response()->json(['status' => 'success']);
    }

    private function formatToWhatsApp($number)
    {
        $number = preg_replace('/[\s\-.]/', '', $number);
        if (\Str::startsWith($number, '08')) {
            $number = '+62' . substr($number, 1);
        }
        if (\Str::startsWith($number, '62')) {
            $number = '+' . $number;
        }
        if (!\Str::startsWith($number, 'whatsapp:')) {
            $number = 'whatsapp:' . $number;
        }
        return $number;
    }
}
