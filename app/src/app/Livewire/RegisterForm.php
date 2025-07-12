<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\PaymentTransaction;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Midtrans\Snap;
use Midtrans\Config as MidtransConfig;

class RegisterForm extends Component
{
    public $name, $email, $phone_number, $address, $nik, $job_title, $course_id;

    public function mount()
    {
        MidtransConfig::$serverKey = config('midtrans.server_key');
        MidtransConfig::$isProduction = false;
        MidtransConfig::$isSanitized = true;
        MidtransConfig::$is3ds = true;
    }

    public function register()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone_number' => 'required',
            'address' => 'required',
            'nik' => 'required',
            'course_id' => 'required|exists:courses,id',
        ]);

        $course = Course::findOrFail($this->course_id);

        $enrollment = CourseEnrollment::create([
            'course_id' => $course->id,
            'enrollment_date' => now(),
            'payment_status' => 'pending',
            'is_completed' => false,
        ]);

        $orderId = 'ORDER-' . strtoupper(Str::random(10));
        $amount = $course->price ?? 100000;

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $amount,
            ],
            'customer_details' => [
                'first_name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone_number,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        PaymentTransaction::create([
            'course_enrollment_id' => $enrollment->id,
            'midtrans_order_id' => $orderId,
            'amount' => $amount,
            'payment_method' => 'midtrans',
            'transaction_status' => 'pending',
            'transaction_time' => now(),
            'expiry_time' => now()->addHours(1),
        ]);

        // Simpan data user ke session untuk diproses setelah pembayaran
        session([
            'enrollment_id' => $enrollment->id,
            'user_data' => [
                'name'         => $this->name,
                'email'        => $this->email,
                'phone_number' => $this->phone_number,
                'address'      => $this->address,
                'nik'          => $this->nik,
                'job_title'    => 'student', // ✅ di-set otomatis
            ],
        ]);
        // Dispatch event to open Midtrans Snap payment
        $this->dispatchBrowserEvent('open-midtrans-snap', [
            'token' => $snapToken,
        ]);
    }


    public function render()
    {
        return view('livewire.register-form', [
            'courses' => \App\Models\Course::where('is_active', true)->get(),
        ]);
    }
}
