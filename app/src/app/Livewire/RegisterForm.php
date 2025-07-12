<?php

namespace App\Livewire;

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\PaymentTransaction;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Midtrans\Snap;
use Midtrans\Config;

class RegisterForm extends Component
{
    public $name, $email, $phone_number, $address, $nik, $course_id;
    public $courses;

    protected $listeners = ['paymentSuccess' => 'handlePaymentSuccess'];

    public function mount()
    {
        $this->courses = Course::where('is_active', true)->get();
    }

    public function register()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required',
            'address' => 'required',
            'nik' => 'required',
            'course_id' => 'required|exists:courses,id',
        ]);

        $course = Course::findOrFail($this->course_id);

        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $orderId = 'ORD-' . strtoupper(Str::random(10));

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $course->price,
            ],
            'customer_details' => [
                'first_name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone_number,
            ],
            'item_details' => [
                [
                    'id' => $course->id,
                    'price' => $course->price,
                    'quantity' => 1,
                    'name' => $course->name,
                ]
            ]
        ];

        $snapToken = Snap::getSnapToken($params);

        session(['register_data' => [
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'address' => $this->address,
            'nik' => $this->nik,
            'course_id' => $this->course_id,
            'order_id' => $orderId,
            'amount' => $course->price,
        ]]);

        $this->dispatchBrowserEvent('open-midtrans-snap', ['token' => $snapToken]);
    }

    public function handlePaymentSuccess($result)
    {
        $data = session('register_data');

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make('password'),
            'phone_number' => $data['phone_number'],
            'address' => $data['address'],
            'nik' => $data['nik'],
            'job_title' => 'Student',
            'department_id' => null,
            'employment_status' => null,
            'onboarding_date' => now(),
            'expertise_area' => 'Web Development',
        ]);
        $user->assignRole('student');

        $enrollment = CourseEnrollment::create([
            'user_id' => $user->id,
            'course_id' => $data['course_id'],
            'enrollment_date' => now(),
            'payment_status' => 'paid',
            'access_granted_at' => now(),
            'is_completed' => false,
        ]);

        PaymentTransaction::create([
            'course_enrollment_id' => $enrollment->id,
            'midtrans_order_id' => $data['order_id'],
            'midtrans_transaction_id' => $result['transaction_id'],
            'amount' => $data['amount'],
            'currency' => 'IDR',
            'payment_method' => $result['payment_type'],
            'transaction_status' => $result['transaction_status'],
            'transaction_time' => now(),
            'settlement_time' => now(),
            'expiry_time' => now()->addDay(),
            'raw_response' => json_encode($result),
        ]);
    }

    public function render()
    {
        return view('livewire.register-form');
    }
}

