<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomerLeadModel;
use App\Models\ApiCloudCallModel;
use Illuminate\Support\Facades\AUTH;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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

        $mytime = Carbon::now('Asia/Kolkata')->format('Y-m-d H:i:s');

        $result =ApiCloudCallModel::create([
            'log_uuid' => $data['log_uuid'],
            'customer_number' => $data['customer_number'],
            'call_type' => $data['call_type'],
            'did_number' => $data['did_number'],
            'call_start_time' => $data['call_start_time'],
            'call_end_time' => $data['call_end_time'],
            'call_duration' => $data['call_duration'],
            'recording' => $data['recording'],
            'call_status' => $data['call_status'],
            'call_mode' => $data['call_mode'],
            'campaign' => $data['campaign'],
            'agents' => $data['agents'],
        ]);


       /*  $result = ApiCloudCallModel::create([
            'uuid' => $data['log_uuid'],
            'caller_number' => $data['caller_number'],
            'caller_name' => $data['caller_name'],
            'user_id' => $data['user_id'],
            'user_email' => $data['user_email'],
            'user_name' => $data['user_name'],
            'did_number' => $data['did_number'],
            'caller_id' => $data['caller_id'],
            'destination_type' => $data['destination_type'],
            'campaign' => $data['campaign'],
            'agent_start_time' => $data['agent_start_time'],
            'agent_answered_time' => $data['agent_answered_time'],
            'agent_end_time' => $data['agent_end_time'],
            'agent_duration' => $data['agent_duration'],
            'customer_start_time' => $data['customer_start_time'],
            'customer_answered_time' => $data['customer_answered_time'],
            'customer_end_time' => $data['customer_end_time'],
            'customer_duration' => $data['customer_duration'],
            'call_start_time' => $data['call_start_time'],
            'call_answered_time' => $data['call_answered_time'],
            'call_end_time' => $data['call_end_time'],
            'call_duration' => $data['call_duration'],
            'total_agents_duration' => $data['total_agents_duration'],
            'queue_duration' => $data['queue_duration'],
            'hold_duration' => $data['hold_duration'],
            'amount' => $data['amount'],
            'recording' => $data['recording'],
            'call_status' => $data['call_status'],
            'call_type' => $data['call_type'],
            'call_mode' => $data['call_mode'],
            'region' => $data['region'],
            'created_at' => $mytime,
            'updated_at' => $mytime,
            
        ]); */

       /*  $result = ApiCloudCallModel::create([
            'uuid' => $data['uuid'],
            'caller_number' => $data['caller_number'],
            'caller_name' => $req->caller_name,
            'user_id' => $req->user_id,
            'user_email' => $req->user_email,
            'user_name' => $req->user_name,
            'did_number' => $req->did_number,
            'caller_id' => $req->caller_id,
            'destination_type' => $req->destination_type,
            'campaign' => $req->campaign,
            'agent_start_time' => $req->agent_start_time,
            'agent_answered_time' => $req->agent_answered_time,
            'agent_end_time' => $req->agent_end_time,
            'agent_duration' => $req->agent_duration,
            'customer_start_time' => $req->customer_start_time,
            'customer_answered_time' => $req->customer_answered_time,
            'customer_end_time' => $req->customer_end_time,
            'customer_duration' => $req->customer_duration,
            'call_start_time' => $req->call_start_time,
            'call_answered_time' => $req->call_answered_time,
            'call_end_time' => $req->call_end_time,
            'call_duration' => $req->call_duration,
            'total_agents_duration' => $req->total_agents_duration,
            'queue_duration' => $req->queue_duration,
            'hold_duration' => $req->hold_duration,
            'amount' => $req->amount,
            'recording' => $req->recording,
            'call_status' => $req->call_status,
            'call_type' => $req->call_type,
            'call_mode' => $req->call_mode,
            'region' => $req->region,
            'created_at' => $mytime,
            'updated_at' => $mytime,
        ]); */

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
        $data['cloud_call_data'] = DB::table('cloud_calling_data')->orderBy('id', 'desc')->get();
        return view('admin.cloud-calling.cloud-calling-data',$data);
    }
}
