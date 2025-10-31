<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WhatsAppApiController extends Controller
{
    function testapi()
    {
        $url = 'https://api.interakt.ai/v1/public/message/';
        $data = [
            "countryCode"  => "+91",
            "phoneNumber"  => "9540000174",
            "callbackData" => "some text here",
            "type"         => "Template",
            "template"     => [
                "name"         => "wel_new_hindi",
                "languageCode" => "hi"
            ]
        ];
        
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        // json_encode() will correctly convert your PHP array to a JSON string
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Basic Y2RjU0Y5Nkdfc0FRREhDQXpjTTB1LThUZExJWnJjSHFLM2U5RVYtMjU1azo='
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_error($ch)) {
            $error = curl_error($ch);
            // You should handle the error here, e.g., log it or return it
            // error_log("cURL Error: " . $error);
        }

        curl_close($ch);

        // Simplified the return statement
        //return json_decode($response, true);
    }

    public function whatsappwebhook(Request $request)
    {
        // Log the incoming request data for debugging
        Log::info('WhatsApp Webhook Data: ', $request->all());

        // Respond with a 200 OK status to acknowledge receipt
        return response()->json(['status' => 'success'], 200);
    }
}
