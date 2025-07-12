<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;

class WhatsAppOtpController extends Controller
{
    public function send(Request $request)
    {
        $phone = $request->phone_number;

        if (!$phone) {
            return response()->json(['error' => 'Nomor tidak boleh kosong'], 422);
        }

        $normalized = $this->normalizePhone($phone);
        $otp = rand(100000, 999999);

        session(['otp_code' => $otp]);

        // Send via Twilio WhatsApp
        try {
            $twilio = new Client(config('services.twilio.sid'), config('services.twilio.token'));
            $twilio->messages->create(
                'whatsapp:' . $normalized,
                [
                    'from' => 'whatsapp:' . config('services.twilio.whatsapp_from'),
                    'body' => "Kode verifikasi UEU Bootcamp Anda adalah: $otp"
                ]
            );

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal mengirim OTP: ' . $e->getMessage()], 500);
        }
    }

    protected function normalizePhone($phone)
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (str_starts_with($phone, '0')) {
            return '62' . substr($phone, 1);
        }
        return $phone;
    }
}
