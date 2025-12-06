<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;


class SmsService
{
    protected $baseUrl = 'https://pgapi.sparc.smartping.io/fe/api/v1/send';

    public function sendCarTransferNotification($purchaser_name, $Purchaser_mobile_number, $reg_number, $online_date,)
    {
        try {
            $formattedDate = Carbon::parse($online_date)->format('d/M/Y');

            $message = "Dear {$purchaser_name},\nOwnership of car {$reg_number} was transferred on {$formattedDate}. Please check mParivahan for your RC. Urgently transfer your insurance to your name.\nThanks,\nCar4Sales, Muzzfarpur";

            $params = [
                'username' => 'car4sales.trans',
                'password' => '@i?-^ho3LBfvxk202',
                'unicode' => 'true',
                'from' => 'C4SALE',
                'text' => $message,
                'to' => $Purchaser_mobile_number,
                'dltContentId' => '1707176503052721615',
                'dltPrincipalEntityId' => '1701171869640632437',
                'dltTelemarketerId' => '1702176485193910037'
            ];

            $response = Http::timeout(30)
                ->withHeaders(['accept' => 'application/json'])
                ->get($this->baseUrl, $params);

            Log::info('SMS Notification Sent', [
                'purchaser_name' => $purchaser_name,
                'Purchaser_mobile_number' => $Purchaser_mobile_number,
                'car_number' => $reg_number,
                'sms_status' => $response->status(),
                'sms_response' => $response->json()
            ]);

            return [
                'success' => $response->successful(),
                'data' => $response->json()
            ];
        } catch (\Exception $e) {
            Log::error('SMS Notification Failed', [
                'purchaser_name' => $purchaser_name,
                'Purchaser_mobile_number' => $Purchaser_mobile_number,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }







    public function __construct()
    {
        // Constructor logic
    }

    // Add your service methods here
}
