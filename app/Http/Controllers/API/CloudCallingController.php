<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomerLeadModel;
use App\Models\ApiCloudCallModel;
use App\Models\API\JustDailModel;
use App\Models\API\QkonnectModel;
use Illuminate\Support\Facades\AUTH;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Stmt\TryCatch;

class CloudCallingController extends Controller
{
    public function index(Request $req)
    {
        $lastid = ApiCloudCallModel::create([
            'Name' => $req->Name,
            'mobile_number' => $req->mobile_number,
            'address' => $req->address,
            'created_by' => $req->created_by,
        ]);

        /* $ApiCloudCallModel = new ApiCloudCallModel;
            $ApiCloudCallModel->Name = trim($req->Name);
            $ApiCloudCallModel->mobile_number = trim($req->mobile_number);
            $ApiCloudCallModel->address =  trim($req->address);
            $ApiCloudCallModel->created_by = trim($req->created_by);
            $ApiCloudCallModel->save();
            $lastid = $ApiCloudCallModel->id; */

        if ($lastid) {
            $sender = 'CAR4SL';
            $mob = $req->mobile_number;
            $name = $req->Name;
            $auth = '3HqJI';
            $entid = '1701171869640632437';
            $temid = '1707172596077833707';
            $mob2 = [$mob];
            $mob3 = implode(',', $mob2);
            $msg = urlencode('Dear ' . $name . ",\nWelcome to Car4Sales ! We're excited to help you Buy & sell your old car with ease and get the best value for it. If you have any questions or need assistance, please contact us at. 7779995656 . \nThank you for choosing us! \nBest regards,\nCar4Sales, \nMuzaffarpur, Motihari, Bakhri \nPh. 7779995656");
            $msg1 = urlencode('प्रिय ' . $name . ",\nCar4Sales में आपका हार्दिक स्वागत है! हम पुरानी कार को खरीदते और बेचते हैं, आपकी पुरानी कार का सर्वोत्तम मूल्य दिलाने एवं किफायती कीमत पर पुरानी कार देने का वादा करते है।\nअपनी कार बेचने एवं पुरानी कार खरीदने के लिए हमसे इस नंबर पर संपर्क करें: 7779995656. \nCar4Sales को चुनने के लिए आपका धन्यवाद!,\nसादर,\nCar4Sales, \nमुजफ्फरपुर, मोतिहारी, दरभंगा  \nफोन: 7779995656");

            $url = 'https://pgapi.vispl.in/fe/api/v1/multiSend?username=car4sales.trans&password=3HqJI&unicode=true&from=' . $sender . '&to=' . $mob . '&dltPrincipalEntityId=' . $entid . '&dltContentId=' . $temid . '&text=' . $msg1;

            //sms from here

            function SendSMS($hostUrl)
            {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $hostUrl);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_POST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // change to 1 to verify cert
                curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
                $result = curl_exec($ch);
                return $result;
            }

            $raa = SendSMS($url); // call function that return response with code

            return response()->json([
                'status' => 'true',
                'message' => 'Data Added Successfully',
            ], 200);
        }
    }

    public function cloudcallingapidata(Request $req)
    {

        $data = $req->json()->all();

        $last_10_digits = substr($data['did_number'], -10);

        $mytime = Carbon::now('Asia/Kolkata')->format('Y-m-d H:i:s');

        $result = ApiCloudCallModel::create([
            'log_uuid' => $data['log_uuid'],
            'customer_number' => $data['customer_number'],
            'call_type' => $data['call_type'],
            'did_number' => $last_10_digits,
            'call_start_time' => $data['call_start_time'],
            'call_end_time' => $data['call_end_time'],
            'call_duration' => $data['call_duration'],
            'recording' => $data['recording'],
            'call_status' => $data['call_status'],
            'call_mode' => $data['call_mode'],
            'campaign' => $data['campaign'],
            'agents' => $data['agents'],
        ]);


        if ($result)

            $sender = 'CAR4SL';
        $mob = $data['customer_number'];
        $name = 'Customer';
        $auth = '3HqJI';
        $entid = '1701171869640632437';
        $temid = '1707172596077833707';
        $mob2 = [$mob];
        $mob3 = implode(',', $mob2);
        $msg = urlencode('Dear ' . $name . ",\nWelcome to Car4Sales ! We're excited to help you Buy & sell your old car with ease and get the best value for it. If you have any questions or need assistance, please contact us at. 7779995656 . \nThank you for choosing us! \nBest regards,\nCar4Sales, \nMuzaffarpur, Motihari, Bakhri \nPh. 7779995656");
        $msg1 = urlencode('प्रिय ' . $name . ",\nCar4Sales में आपका हार्दिक स्वागत है! हम पुरानी कार को खरीदते और बेचते हैं, आपकी पुरानी कार का सर्वोत्तम मूल्य दिलाने एवं किफायती कीमत पर पुरानी कार देने का वादा करते है।\nअपनी कार बेचने एवं पुरानी कार खरीदने के लिए हमसे इस नंबर पर संपर्क करें: 7779995656. \nCar4Sales को चुनने के लिए आपका धन्यवाद!,\nसादर,\nCar4Sales, \nमुजफ्फरपुर, मोतिहारी, दरभंगा  \nफोन: 7779995656");

        $url = 'https://pgapi.vispl.in/fe/api/v1/multiSend?username=car4sales.trans&password=3HqJI&unicode=true&from=' . $sender . '&to=' . $mob . '&dltPrincipalEntityId=' . $entid . '&dltContentId=' . $temid . '&text=' . $msg1;

        //sms from here

        function SendSMS($hostUrl)
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $hostUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_POST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // change to 1 to verify cert
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            $result = curl_exec($ch);
            return $result;
        }

        $raa = SendSMS($url); // call function that return response with code

        {
            return response()->json([
                'status' => 'success',
                'message' => 'call log Received',
            ], 200);
        }
    }

    public function showcloudacalldata()
    {
        $now = Carbon::now();
        $sevenDaysAgo = $now->copy()->subDays(15);

        $data['cloud_call_data'] = DB::table('cloud_calling_data')->whereDate('created_at', '>=', $sevenDaysAgo)->get();

        return view('admin.cloud-calling.cloud-calling-data', $data);
    }

    public function JustDailData(Request $req)
    {
        // Best Practice: Validate the incoming data first
        $validator = Validator::make($req->all(), [
            'leadid' => 'required',
            'name' => 'required|string|max:255',

            // Add other validation rules as needed...
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Get validated data
        $data1 = $validator->validated();
        $data = $req->json()->all();

        try {
            // Correction 1: Changed $$data['name'] to $data['name']
            $result = JustDailModel::create([
                'leadid' => $data['leadid'],
                'leadtype' => $data['leadtype'] ?? null,
                'prefix' => $data['prefix'] ?? null,
                'name' => $data['name'], // Corrected from $$data['name']
                'mobile' => $data['mobile'],
                'phone' => $data['phone'],
                'email' => $data['email'] ?? null,
                'date' => $data['date'] ?? null,
                'category' => $data['category'] ?? null,
                'area' => $data['area'] ?? null,
                'city' => $data['city'] ?? null,
                'brancharea' => $data['brancharea'] ?? null,
                'dncmobile' => $data['dncmobile'] ?? null,
                'dncphone' => $data['dncphone'] ?? null,
                'company' => $data['company'] ?? null,
                'pincode' => $data['pincode'] ?? null,
                'time' => $data['time'] ?? null,
                'branchpin' => $data['branchpin'] ?? null,
                'parentid' => $data['parentid'] ?? null,
            ]);

            if ($result) {
                // Correction 2: Added the 'return' keyword
                return response()->json([
                    'status' => 'success',
                    'message' => 'RECEIVED',
                ], 200);
            }
        } catch (\Exception $e) {
            // Optional: Log the actual error for debugging
            Log::error('Failed to save JustDial data: ' . $e->getMessage());

            // Correction 3: Handle potential errors
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to save data. Please try again.',
            ], 500);
        }
    }

    public function showjustdaildata()
    {
        $now = Carbon::now();
        $fifteenDaysAgo = $now->copy()->subDays(15);

        $data['just_dail_data'] = DB::table('just_dail_data')
            ->whereDate('created_at', '>=', $fifteenDaysAgo)
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.just-dail.just-dail-data', $data);
    }
    public function qkonnectData(Request $req)
    {
        $data = $req->json()->all();

        try {

             $url = 'https://api.interakt.ai/v1/public/message/';
        $data = [
            "countryCode"  => "+91",
            "phoneNumber"  => $data['caller_number'],
            "campaignId"  => $data['4c54326f-0d3b-411f-a458-1c92df296e7e'],
            "callbackData" => "some text here",
            "type"         => "Template",
            "template"     => [
                "name"         => "welcome_msg_qb",
                "languageCode" => "en"
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
            
            $result = QkonnectModel::create([

                'caller_number' => $data['caller_number'] ?? null,
                'Call_type' => $data['Call_type'] ?? null,
                'call_id' => $data['call_id'] ?? null,
                'call_start_time' => $data['call_start_time'] ?? null,
                'call_pickup_time' => $data['call_pickup_time'] ?? null,
                'total_call_time' => $data['total_call_time'] ?? null,
                'call_transfer_time' => $data['call_transfer_time'] ?? null,
                'call_recording' => $data['call_recording'] ?? null,
                'call_hangup_cause' => $data['call_hangup_cause'] ?? null,
                'destination_number' => $data['destination_number'] ?? null,
                'agent_number' => $data['agent_number'] ?? null,
                'call_end_time' => $data['call_end_time'] ?? null,
                'call_hangup_time' => $data['call_hangup_time'] ?? null,
                'call_action' => $data['call_action'] ?? null,
                'call_confrence_uid' => $data['call_confrence_uid'] ?? null,
                'call_status' => $data['call_status'] ?? null,
            ]);

            if ($result) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'call log Received',
                ], 200);
            }

        } catch (\Exception $e) {
            Log::error('Failed to save Qkonnect data: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to save data. Please try again.',
            ], 500);
        }
    }
    public function showqkonnectdata()
    {
        $now = Carbon::now();
        $fifteenDaysAgo = $now->copy()->subDays(15);

        $data['qkonnect_Data'] = DB::table('qkonnect_data')
            ->whereDate('created_at', '>=', $fifteenDaysAgo)
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.cloud-calling.qkonnect-call-data', $data);
    }
}
