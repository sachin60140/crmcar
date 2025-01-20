<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmpModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\CustomerLeadModel;
use App\Models\VisitorModel;
use App\Models\UpdateRemarksCustomerLeadModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;


class EmpController extends Controller
{
    public function employee()
    {

        return view('admin.employee.add-employee');
    }

    public function addemployee(Request $req)
    {

    }

    public function emplogin()
    {
        if (!empty(Auth::check())) {
            return redirect('employee/dashboard');
        }
        return view('employee.login');
    }

    public function empauthlogin(Request $req)
    {
        if (Auth::attempt(['email' => $req->email, 'password' => $req->password], true)) {
            return redirect('employee/dashboard');
        } else {
            return redirect()->back()->with('error', 'Email or password is incorrect');
        }
    }

    public function emplogout(Request $request): RedirectResponse
    {
        Session::flush();
        
        Auth::logout();

        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/employee');
    }

    public function dashboard()
    {

        $data['totalstock'] = DB::table('car_stock')->count();
        $data['totalbranch'] = DB::table('branch')->count();
        
        $data['contacts'] = DB::table('customer_lead')
                            ->where('created_by', Auth::user()->name)
                            ->count();

        $data['pending_lead_data'] = DB::table('customer_lead')
                            ->where('lead_asign', Auth::user()->name)
                            ->where('lead_status','6')
                            ->count();
        $data['visit_followup_data'] = DB::table('customer_lead')
                            ->where('lead_asign', Auth::user()->name)
                            ->where('lead_status','2')
                            ->count();
        $data['calling_followup_data'] = DB::table('customer_lead')
                            ->where('lead_asign', Auth::user()->name)
                            ->where('lead_status','1')
                            ->count();
        $data['wrong_number_data'] = DB::table('customer_lead')
                            ->where('lead_asign', Auth::user()->name)
                            ->where('lead_status','4')
                            ->count();
        $data['not_answer_number_data'] = DB::table('customer_lead')
                            ->where('lead_asign', Auth::user()->name)
                            ->where('lead_status','5')
                            ->count();
         $data['not_intrested_data'] = DB::table('customer_lead')
                            ->where('lead_asign', Auth::user()->name)
                            ->where('lead_status','3')
                            ->count();
        $data['after_visit_reject_data'] = DB::table('customer_lead')
                            ->where('lead_asign', Auth::user()->name)
                            ->where('lead_status','7')
                            ->count();
       $data['Pendingtilltoday'] = DB::table('customer_lead_remarks')
                            ->where('created_by', Auth::user()->name)
                            ->where('next_folloup_date','<', Carbon::now())
                            ->distinct('cust_lead_id')
                            ->count('cust_lead_id');
                                                
        
        return view('employee.dashboard',$data);
    }

    public function addlead()
    {
        $data['leadtype'] = DB::table('lead_category')
                            ->orderBy('lead_type','asc')
                            ->get();
        
        return view('employee.data.add-data',$data);
    }

    public function storeleaddata(Request $req)
    {
        $req->validate([
                
            'name' => 'required',
            'mobile_number' => 'required|numeric|min_digits:10|max_digits:10|unique:customer_lead',
            'address' => 'required',
        ]);
        $mytime = Carbon::now('Asia/Kolkata')->format('Y-m-d H:i:s');
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
            $CustomerLeadModel->enquiry_car_details = $req->enquiry_car_details;
            $CustomerLeadModel->lead_status = '1';
            $CustomerLeadModel->lead_type = $req->lead_type;
            $CustomerLeadModel->lead_asign = Auth::user()->name;
            $CustomerLeadModel->created_by = Auth::user()->name;

            $CustomerLeadModel->save();
            $lastid = $CustomerLeadModel->id;

            $car_details = $req->enquiry_car_details;
            $remarks = $req->remark;
            $lead_status = 'Calling-Follow-UP';

            if($lastid)
            {
                $UpdateRemarksCustomerLeadModel = new UpdateRemarksCustomerLeadModel();
    
                $UpdateRemarksCustomerLeadModel->cust_lead_id = $lastid;
                $UpdateRemarksCustomerLeadModel->next_folloup_date = $req->next_folloup;
                $UpdateRemarksCustomerLeadModel->calling_stage =  $lead_status;
                $UpdateRemarksCustomerLeadModel->cus_remarks = $lead_status.'-'.$car_details.'-'.$remarks;
                $UpdateRemarksCustomerLeadModel->created_by = Auth::user()->name;
                $UpdateRemarksCustomerLeadModel->created_at = $mytime;
    
                $UpdateRemarksCustomerLeadModel->save();
                $lastid = $UpdateRemarksCustomerLeadModel->id;
    
            }
  
        return back()->with('success', ' Lead Added Successfully: ' .$lastid);
    }
    public function viewleaddata()
    {
       $data = DB::table('customer_lead')
                    ->join('calling_customer_status','customer_lead.lead_status','=','calling_customer_status.id')
                    ->select('customer_lead.*','calling_customer_status.calling_status')
                    ->where('lead_asign', Auth::user()->name)
                    ->where('lead_status','6')
                    ->get();
       
       
        return view('employee.data.view-data',compact('data'));
    }


    public function visitor()
    {
        return view('employee.visitor.add-visitor');
    }

    public function addvisitor(Request $req)
    {
        $req->validate([
                
            'name' => 'required',
            'mobile_number' => 'required|numeric|min_digits:10|max_digits:10|unique:visitor',
            'car_require' => 'required',
            'refrence' => 'required',
            'address' => 'required',
        ]);
        $sender = 'CAR4SL';
        $mob = $req->mobile_number;
        $name =$req->name;
        $branch = 'Muzaffarpur';
        $auth = '3HqJI';
        $entid = '1701171869640632437';
        $temid = '1707172494968515032';
        $mob2 = [$mob];
        $mob3 = implode(',', $mob2);
        $msg = urlencode('प्रिय '. $name . ",\n Car4Sales, " . $branch . " में आज आने के लिए धन्यवाद। हमें खुशी है कि आप हमारे वाहनों में रुचि रखते हैं और हमें उम्मीद है कि हमने आपकी सहायता करने में सफल रहे। यदि आपके पास और कोई प्रश्न हैं या और मदद की ज़रूरत हो, तो कृपया बेझिझक हमसे संपर्क करें। आपकी सेवा में पुनः उपस्थित होने की प्रतीक्षा में! \nसादर,\nCar4Sales, \nMuzaffarpur, Motihari, Bakhri \nPh. 7779995656");

        $url = 'https://pgapi.vispl.in/fe/api/v1/multiSend?username=car4sales.trans&password=3HqJI&unicode=true&from=' . $sender . '&to=' . $mob . '&dltPrincipalEntityId=' . $entid . '&dltContentId=' . $temid . '&text=' . $msg;

        //sms from here

        function SendSMS1($hostUrl)
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

        SendSMS1($url);

        $VisitorModel = new VisitorModel;

            $VisitorModel->name = $req->name;
            $VisitorModel->mobile_number = $req->mobile_number;
            $VisitorModel->address = $req->address;
            $VisitorModel->car_require = $req->car_require;
            $VisitorModel->refrence = $req->refrence;
            $VisitorModel->added_by = Auth::user()->name;

            $VisitorModel->save();
            $lastid = $VisitorModel->id;

        return back()->with('success', ' Visitor Added Successfully: ' .$lastid);

    }

    public function viewvisitor()
    {
        $data = DB::table('visitor')
                    ->where('added_by', Auth::user()->name)
                    ->get();
        return view('employee.visitor.view-visitor',compact('data'));
    }

    public function updateleaddata($id)
    {
       
        $data['lead_data'] = DB::table('customer_lead')->where('id','=' ,$id)->first();

        $data['lead_category'] = DB::table('lead_category')
                            ->orderBy('lead_type','asc')
                            ->get();
        
        $data['calling_status'] = DB::table('calling_customer_status')
                            ->orderBy('calling_status','asc')
                            ->get();

        $data['remarks'] = DB::table('customer_lead_remarks')->where('cust_lead_id', '=', $id)->orderBy('id', 'desc')->get();
        
        return  view ('employee.data.update-data',$data);
    }

    public function storeupdatedleaddata(Request $req, $id)
    {

        $req->validate([
            'name' => 'required',
            'mobile_number' => 'required|numeric|min_digits:10|max_digits:10',
            'remark' => 'required',
        ]);

        

        $mytime = Carbon::now('Asia/Kolkata')->format('Y-m-d H:i:s');

       $customer_id = $id;

        $CustomerLeadModel = CustomerLeadModel::find($customer_id);

        $CustomerLeadModel->Name = $req->name;
        $CustomerLeadModel->mobile_number = $req->mobile_number;
        $CustomerLeadModel->lead_type = $req->lead_category;
        $CustomerLeadModel->address = $req->address	;
        $CustomerLeadModel->enquiry_car_details = $req->enquiry_car_details;
        $CustomerLeadModel->lead_status = $req->calling_status;
        $CustomerLeadModel->updated_by = Auth::user()->name;
        $CustomerLeadModel->updated_at = $mytime;

        $result = $CustomerLeadModel->update();

            $car_details = $req->enquiry_car_details;
            $remarks = $req->remark;
            $lead_status = DB::table('calling_customer_status')
                            ->where('id',$req->calling_status)
                            ->select('calling_status')
                            ->first();
            $lead_status_details = $lead_status->calling_status;

        if($result)
        {
            $UpdateRemarksCustomerLeadModel = new UpdateRemarksCustomerLeadModel();

            $UpdateRemarksCustomerLeadModel->cust_lead_id = $customer_id;
            $UpdateRemarksCustomerLeadModel->calling_stage = $lead_status_details;
            $UpdateRemarksCustomerLeadModel->next_folloup_date = $req->next_folloup;
            $UpdateRemarksCustomerLeadModel->cus_remarks =  $lead_status_details.'-'.$car_details.'-'.$remarks;
            $UpdateRemarksCustomerLeadModel->created_by = Auth::user()->name;
            $UpdateRemarksCustomerLeadModel->created_at = $mytime;

            $UpdateRemarksCustomerLeadModel->save();
            $lastid = $UpdateRemarksCustomerLeadModel->id;

        }
        return redirect('employee/data/view-lead')->with('success', 'Remarks Added Successfully: ' . $lastid);
    }

    public function callingfollouplead()
    {
        $data['calling_lead'] = DB::table('customer_lead')
                    ->join('calling_customer_status','customer_lead.lead_status','=','calling_customer_status.id')
                    ->select('customer_lead.*','calling_customer_status.calling_status')
                    ->where('lead_asign', Auth::user()->name)
                    ->where('lead_status','1')
                    ->get();

        return view('employee.data.calling-folloup-lead',$data);
    }

    public function visitfollowuplead()
    {
        $data['calling_lead'] = DB::table('customer_lead')
                                ->join('calling_customer_status','customer_lead.lead_status','=','calling_customer_status.id')
                                ->select('customer_lead.*','calling_customer_status.calling_status')
                                ->where('lead_asign', Auth::user()->name)
                                ->where('lead_status','2')
                                ->get();

        return view('employee.data.visit-followup-lead',$data);
    }
    
}
