<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerLeadModel;
use Auth;
use Illuminate\Support\Facades\DB;

class CustomerLeadController extends Controller
{
    public function addlead()
    {
        return view('admin.Data.add-data');
    }

    public function storeleaddata(Request $req)
    {
        $req->validate([
                
            'name' => 'required',
            'mobile_number' => 'required|numeric|unique:customer_lead',
            'address' => 'required',
        ]);

        $sender = 'CAR4SL';
        $mob = $req->mobile_number;
        $name =$req->name;
        $auth = '3HqJI';
        $entid = '1701171869640632437';
        $temid = '1707172596077833707';
        $mob2 = [$mob];
        $mob3 = implode(',', $mob2);
        $msg = urlencode('Dear '. $name . ",\nWelcome to Car4Sales ! We're excited to help you Buy & sell your old car with ease and get the best value for it. If you have any questions or need assistance, please contact us at. 7779995656 . \nThank you for choosing us! \nBest regards,\nCar4Sales, \nMuzaffarpur, Motihari, Bakhri \nPh. 7779995656");
        $msg1 = urlencode('प्रिय '. $name . ",\nCar4Sales में आपका हार्दिक स्वागत है! हम पुरानी कार को खरीदते और बेचते हैं, आपकी पुरानी कार का सर्वोत्तम मूल्य दिलाने एवं किफायती कीमत पर पुरानी कार देने का वादा करते है।\nअपनी कार बेचने एवं पुरानी कार खरीदने के लिए हमसे इस नंबर पर संपर्क करें: 7779995656. \nCar4Sales को चुनने के लिए आपका धन्यवाद!,\nसादर,\nCar4Sales, \nमुजफ्फरपुर, मोतिहारी, दरभंगा  \nफोन: 7779995656");

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
        
            $CustomerLeadModel = new CustomerLeadModel;

            $CustomerLeadModel->Name = $req->name;
            $CustomerLeadModel->mobile_number = $req->mobile_number;
            $CustomerLeadModel->address = $req->address;
            $CustomerLeadModel->created_by = Auth::user()->name;

            $CustomerLeadModel->save();
            $lastid = $CustomerLeadModel->id;
  
        return back()->with('success', ' Lead Added Successfully: ' .$lastid);
    }
    public function viewleaddata()
    {
        $data = DB::table('customer_lead')->get();
       
        return view('admin.Data.view-data',compact('data'));
    }
}
