<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomerLeadModel;
use App\Models\ApiCloudCallModel;
use Illuminate\Support\Facades\AUTH;

class CloudCallingController extends Controller
{
    public function index(Request $req)
    {

        /* $lastid = ApiCloudCallModel::create([
            'Name' => $req->Name,
            'mobile_number' => $req->mobile_number,
            'address' => $req->address,
            'created_by' => $req->created_by,
        ]); */

            $ApiCloudCallModel = new ApiCloudCallModel;
            $ApiCloudCallModel->Name = trim($req->Name);
            $ApiCloudCallModel->mobile_number = trim($req->mobile_number);
            $ApiCloudCallModel->address = trim($req->address);
            $ApiCloudCallModel->created_by = trim($req->created_by);
            $ApiCloudCallModel->save();
            $lastid = $ApiCloudCallModel->id;

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
}
