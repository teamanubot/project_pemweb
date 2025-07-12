<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;

class WhatsAppController extends Controller
{
    public function sendWhatsAppMessage(Request $request)
    {
        $twilioSid = env('TWILIO_SID');
        $twilioToken = env('TWILIO_AUTH_TOKEN');
        $twilioWhatsAppNumber = env('TWILIO_WHATSAPP_NUMBER', '+14155238886');

        $recipientNumber = $request->input('recipient_number');
        $message = $request->input('message', 'Halo dari UEU Bootcamp!');

        if (!str_starts_with($recipientNumber, 'whatsapp:')) {
            $recipientNumber = 'whatsapp:' . $recipientNumber;
        }

        if (!str_starts_with($twilioWhatsAppNumber, 'whatsapp:')) {
            $twilioWhatsAppNumber = 'whatsapp:' . $twilioWhatsAppNumber;
        }

        $twilio = new Client($twilioSid, $twilioToken);

        try {
            $twilio->messages->create(
                $recipientNumber,
                [
                    'from' => $twilioWhatsAppNumber,
                    'body' => $message,
                ]
            );

            return response()->json(['message' => 'Pesan WhatsApp berhasil dikirim']);
        } catch (\Exception $e) {
            \Log::error('Gagal kirim WA: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
