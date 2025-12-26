<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


class EmpController extends Controller
{
    public function employee()
    {

        return view('admin.employee.add-employee');
    }

    public function addemployee(Request $req) {}

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

    // public function dashboard()
    // {

    //     $data['totalstock'] = DB::table('car_stock')->count();
    //     $data['totalbranch'] = DB::table('branch')->count();

    //     $data['contacts'] = DB::table('customer_lead')
    //         ->where('created_by', Auth::user()->name)
    //         ->count();

    //     $data['pending_lead_data'] = DB::table('customer_lead')
    //         ->where('lead_asign', Auth::user()->name)
    //         ->where('lead_status', '6')
    //         ->count();
    //     $data['visit_followup_data'] = DB::table('customer_lead')
    //         ->where('lead_asign', Auth::user()->name)
    //         ->where('lead_status', '2')
    //         ->count();
    //     $data['calling_followup_data'] = DB::table('customer_lead')
    //         ->where('lead_asign', Auth::user()->name)
    //         ->where('lead_status', '1')
    //         ->count();
    //     $data['wrong_number_data'] = DB::table('customer_lead')
    //         ->where('lead_asign', Auth::user()->name)
    //         ->where('lead_status', '4')
    //         ->count();
    //     $data['not_answer_number_data'] = DB::table('customer_lead')
    //         ->where('lead_asign', Auth::user()->name)
    //         ->where('lead_status', '5')
    //         ->count();
    //     $data['not_intrested_data'] = DB::table('customer_lead')
    //         ->where('lead_asign', Auth::user()->name)
    //         ->where('lead_status', '3')
    //         ->count();
    //     $data['after_visit_reject_data'] = DB::table('customer_lead')
    //         ->where('lead_asign', Auth::user()->name)
    //         ->where('lead_status', '7')
    //         ->count();
    //     $data['Pendingtilltoday'] = DB::table('customer_lead_remarks')
    //         ->where('created_by', Auth::user()->name)
    //         ->where('next_folloup_date', '<', Carbon::now())
    //         ->distinct('cust_lead_id')
    //         ->count('cust_lead_id');


    //     return view('employee.dashboard', $data);
    // }

    public function dashboard()
    {
        $userName = Auth::user()->name;
        $now = Carbon::now();

        // 1. General System Counts
        $data['totalstock'] = DB::table('car_stock')->count();
        $data['totalbranch'] = DB::table('branch')->count();

        // 2. Leads Created by User
        $data['contacts'] = DB::table('customer_lead')
            ->where('created_by', $userName)
            ->count();

        // 3. Status Counts (Optimized: 7 Queries combined into 1)
        // We fetch all status counts for this user in one go.
        $statusCounts = DB::table('customer_lead')
            ->where('lead_asign', $userName)
            ->selectRaw("
            count(CASE WHEN lead_status = '6' THEN 1 END) as pending_lead,
            count(CASE WHEN lead_status = '2' THEN 1 END) as visit_followup,
            count(CASE WHEN lead_status = '1' THEN 1 END) as calling_followup,
            count(CASE WHEN lead_status = '4' THEN 1 END) as wrong_number,
            count(CASE WHEN lead_status = '5' THEN 1 END) as not_answer,
            count(CASE WHEN lead_status = '3' THEN 1 END) as not_intrested,
            count(CASE WHEN lead_status = '7' THEN 1 END) as after_visit_reject
        ")
            ->first();

        // Assign the optimized results to your data array
        $data['pending_lead_data']      = $statusCounts->pending_lead;
        $data['visit_followup_data']    = $statusCounts->visit_followup;
        $data['calling_followup_data']  = $statusCounts->calling_followup;
        $data['wrong_number_data']      = $statusCounts->wrong_number;
        $data['not_answer_number_data'] = $statusCounts->not_answer;
        $data['not_intrested_data']     = $statusCounts->not_intrested;
        $data['after_visit_reject_data'] = $statusCounts->after_visit_reject;

        // 4. Pending Follow-ups (Distinct Count)
        $data['Pendingtilltoday'] = DB::table('customer_lead_remarks')
            ->where('created_by', $userName)
            ->where('next_folloup_date', '<', $now)
            ->distinct('cust_lead_id')
            ->count('cust_lead_id');

        return view('employee.dashboard', $data);
    }
    public function addlead()
    {
        $data['leadtype'] = DB::table('lead_category')
            ->orderBy('lead_type', 'asc')
            ->get();

        return view('employee.data.add-data', $data);
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
        $name = $req->name;
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

        if ($lastid) {
            $UpdateRemarksCustomerLeadModel = new UpdateRemarksCustomerLeadModel();

            $UpdateRemarksCustomerLeadModel->cust_lead_id = $lastid;
            $UpdateRemarksCustomerLeadModel->next_folloup_date = $req->next_folloup;
            $UpdateRemarksCustomerLeadModel->calling_stage =  $lead_status;
            $UpdateRemarksCustomerLeadModel->cus_remarks = $lead_status . '-' . $car_details . '-' . $remarks;
            $UpdateRemarksCustomerLeadModel->created_by = Auth::user()->name;
            $UpdateRemarksCustomerLeadModel->created_at = $mytime;

            $UpdateRemarksCustomerLeadModel->save();
            $lastid = $UpdateRemarksCustomerLeadModel->id;
        }

        return back()->with('success', ' Lead Added Successfully: ' . $lastid);
    }
    public function viewleaddata()
    {
        $data = DB::table('customer_lead')
            ->join('calling_customer_status', 'customer_lead.lead_status', '=', 'calling_customer_status.id')
            ->select('customer_lead.*', 'calling_customer_status.calling_status')
            ->where('lead_asign', Auth::user()->name)
            ->where('lead_status', '6')
            ->get();


        return view('employee.data.view-data', compact('data'));
    }


    public function visitor()
    {
        return view('employee.visitor.add-visitor');
    }

    // public function addvisitor(Request $req)
    // {
    //     $req->validate([

    //         'name' => 'required',
    //         'mobile_number' => 'required|numeric|min_digits:10|max_digits:10|unique:visitor',
    //         'car_require' => 'required',
    //         'refrence' => 'required',
    //         'address' => 'required',
    //     ]);
    //     $sender = 'CAR4SL';
    //     $mob = $req->mobile_number;
    //     $name =$req->name;
    //     $branch = 'Muzaffarpur';
    //     $auth = '3HqJI';
    //     $entid = '1701171869640632437';
    //     $temid = '1707172494968515032';
    //     $mob2 = [$mob];
    //     $mob3 = implode(',', $mob2);
    //     $msg = urlencode('प्रिय '. $name . ",\n Car4Sales, " . $branch . " में आज आने के लिए धन्यवाद। हमें खुशी है कि आप हमारे वाहनों में रुचि रखते हैं और हमें उम्मीद है कि हमने आपकी सहायता करने में सफल रहे। यदि आपके पास और कोई प्रश्न हैं या और मदद की ज़रूरत हो, तो कृपया बेझिझक हमसे संपर्क करें। आपकी सेवा में पुनः उपस्थित होने की प्रतीक्षा में! \nसादर,\nCar4Sales, \nMuzaffarpur, Motihari, Bakhri \nPh. 7779995656");

    //     $url = 'https://pgapi.vispl.in/fe/api/v1/multiSend?username=car4sales.trans&password=3HqJI&unicode=true&from=' . $sender . '&to=' . $mob . '&dltPrincipalEntityId=' . $entid . '&dltContentId=' . $temid . '&text=' . $msg;

    //     //sms from here

    //     function SendSMS1($hostUrl)
    //     {
    //         $ch = curl_init();
    //         curl_setopt($ch, CURLOPT_URL, $hostUrl);
    //         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //         curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    //         curl_setopt($ch, CURLOPT_POST, 0);
    //         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // change to 1 to verify cert
    //         curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
    //         $result = curl_exec($ch);
    //         return $result;
    //     }

    //     SendSMS1($url);

    //     $VisitorModel = new VisitorModel;

    //         $VisitorModel->name = $req->name;
    //         $VisitorModel->mobile_number = $req->mobile_number;
    //         $VisitorModel->address = $req->address;
    //         $VisitorModel->car_require = $req->car_require;
    //         $VisitorModel->refrence = $req->refrence;
    //         $VisitorModel->added_by = Auth::user()->name;

    //         $VisitorModel->save();
    //         $lastid = $VisitorModel->id;

    //     return back()->with('success', ' Visitor Added Successfully: ' .$lastid);

    // }

    // public function addvisitor(Request $request)
    // {
    //     // 1. Validate Input
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'mobile_number' => 'required|numeric|digits:10|unique:visitor,mobile_number',
    //         'car_require' => 'required|string',
    //         'refrence' => 'required|string', // Kept your spelling 'refrence' to match DB
    //         'address' => 'required|string',
    //     ]);

    //     // 2. Prepare SMS Data
    //     $sender = 'CAR4SL';
    //     $entid = '1701171869640632437';
    //     $temid = '1707172494968515032';
    //     $dltTelemarketerId = '1702176485193910037';
    //     $branch = 'Muzaffarpur';

    //     // Construct Message
    //     // Note: No need to use urlencode() manually, the Http helper does it.
    //     $message = "प्रिय {$request->name},\n Car4Sales, {$branch} में आज आने के लिए धन्यवाद। हमें खुशी है कि आप हमारे वाहनों में रुचि रखते हैं और हमें उम्मीद है कि हमने आपकी सहायता करने में सफल रहे। यदि आपके पास और कोई प्रश्न हैं या और मदद की ज़रूरत हो, तो कृपया बेझिझक हमसे संपर्क करें। आपकी सेवा में पुनः उपस्थित होने की प्रतीक्षा में! \nसादर,\nCar4Sales, \nMuzaffarpur, Motihari, Bakhri \nPh. 7779995656";

    //     // 3. Send SMS (Non-blocking attempt)
    //     try {
    //         Http::get('https://pgapi.sparc.smartping.io/fe/api/v1/send', [
    //             'username' => 'car4sales.trans',
    //             'password' => '@i?-^ho3LBfvxk202',
    //             'unicode' => 'true',
    //             'from' => $sender,
    //             'to' => $request->mobile_number,
    //             'dltPrincipalEntityId' => $entid,
    //             'dltContentId' => $temid,
    //             'text' => $message
    //         ]);
    //     } catch (\Exception $e) {
    //         // Log error but allow visitor to be saved
    //         Log::error("Visitor SMS Failed: " . $e->getMessage());
    //     }

    //     // 4. Save to Database
    //     try {
    //         $visitor = new VisitorModel();
    //         $visitor->name = $request->name;
    //         $visitor->mobile_number = $request->mobile_number;
    //         $visitor->address = $request->address;
    //         $visitor->car_require = $request->car_require;
    //         $visitor->refrence = $request->refrence; // Matches input name
    //         $visitor->added_by = Auth::user()->name;

    //         $visitor->save();

    //         return back()->with('success', 'Visitor Added Successfully: ' . $visitor->id);
    //     } catch (\Exception $e) {
    //         return back()->with('error', 'Error adding visitor: ' . $e->getMessage())->withInput();
    //     }
    // }

    public function addvisitor(Request $request)
    {
        // 1. Manual Validation for AJAX
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'mobile_number' => 'required|numeric|digits:10|unique:visitor,mobile_number',
            'car_require' => 'required|string',
            'refrence' => 'required|string',
            'address' => 'required|string',
        ]);

        // If validation fails, return JSON with errors
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ]);
        }

        // 2. Prepare SMS Data
        $sender = 'CAR4SL';
        $entid = '1701171869640632437';
        $temid = '1707172494968515032';
        // $dltTelemarketerId = '1702176485193910037'; // Not used in API call below, but kept if needed
        $branch = 'Muzaffarpur';

        $message = "प्रिय {$request->name},\n Car4Sales, {$branch} में आज आने के लिए धन्यवाद। हमें खुशी है कि आप हमारे वाहनों में रुचि रखते हैं और हमें उम्मीद है कि हमने आपकी सहायता करने में सफल रहे। यदि आपके पास और कोई प्रश्न हैं या और मदद की ज़रूरत हो, तो कृपया बेझिझक हमसे संपर्क करें। आपकी सेवा में पुनः उपस्थित होने की प्रतीक्षा में! \nसादर,\nCar4Sales, \nMuzaffarpur, Motihari, Bakhri \nPh. 7779995656";

        // 3. Send SMS (Non-blocking attempt)
        try {
            // Updated URL and Password from your latest code
            Http::get('https://pgapi.sparc.smartping.io/fe/api/v1/send', [
                'username' => 'car4sales.trans',
                'password' => '@i?-^ho3LBfvxk202', // Updated Password
                'unicode' => 'true',
                'from' => $sender,
                'to' => $request->mobile_number,
                'dltPrincipalEntityId' => $entid,
                'dltContentId' => $temid,
                'text' => $message
            ]);
        } catch (\Exception $e) {
            Log::error("Visitor SMS Failed: " . $e->getMessage());
        }

        // 4. Save to Database
        try {
            $visitor = new VisitorModel();
            $visitor->name = $request->name;
            $visitor->mobile_number = $request->mobile_number;
            $visitor->address = $request->address;
            $visitor->car_require = $request->car_require;
            $visitor->refrence = $request->refrence;
            $visitor->added_by = Auth::user()->name;

            $visitor->save();

            // Success Response
            return response()->json([
                'status' => 200,
                'message' => 'Visitor Added Successfully! ID: ' . $visitor->id
            ]);
        } catch (\Exception $e) {
            // Database Error Response
            return response()->json([
                'status' => 500,
                'message' => 'Error adding visitor: ' . $e->getMessage()
            ]);
        }
    }

    public function viewvisitor()
    {
        $data = DB::table('visitor')
            ->where('added_by', Auth::user()->name)
            ->orderBy('id', 'desc')
            ->get();
        return view('employee.visitor.view-visitor', compact('data'));
    }

    public function updateleaddata($id)
    {

        $data['lead_data'] = DB::table('customer_lead')->where('id', '=', $id)->first();

        $data['lead_category'] = DB::table('lead_category')
            ->orderBy('lead_type', 'asc')
            ->get();

        $data['calling_status'] = DB::table('calling_customer_status')
            ->orderBy('calling_status', 'asc')
            ->get();

        $data['remarks'] = DB::table('customer_lead_remarks')->where('cust_lead_id', '=', $id)->orderBy('id', 'desc')->get();

        return  view('employee.data.update-data', $data);
    }

    // public function storeupdatedleaddata(Request $req, $id)
    // {

    //     $req->validate([
    //         'name' => 'required',
    //         'mobile_number' => 'required|numeric|min_digits:10|max_digits:10',
    //         'remark' => 'required',
    //     ]);



    //     $mytime = Carbon::now('Asia/Kolkata')->format('Y-m-d H:i:s');

    //    $customer_id = $id;

    //     $CustomerLeadModel = CustomerLeadModel::find($customer_id);

    //     $CustomerLeadModel->Name = $req->name;
    //     $CustomerLeadModel->mobile_number = $req->mobile_number;
    //     $CustomerLeadModel->lead_type = $req->lead_category;
    //     $CustomerLeadModel->address = $req->address	;
    //     $CustomerLeadModel->enquiry_car_details = $req->enquiry_car_details;
    //     $CustomerLeadModel->lead_status = $req->calling_status;
    //     $CustomerLeadModel->updated_by = Auth::user()->name;
    //     $CustomerLeadModel->updated_at = $mytime;

    //     $result = $CustomerLeadModel->update();

    //         $car_details = $req->enquiry_car_details;
    //         $remarks = $req->remark;
    //         $lead_status = DB::table('calling_customer_status')
    //                         ->where('id',$req->calling_status)
    //                         ->select('calling_status')
    //                         ->first();
    //         $lead_status_details = $lead_status->calling_status;

    //     if($result)
    //     {
    //         $UpdateRemarksCustomerLeadModel = new UpdateRemarksCustomerLeadModel();

    //         $UpdateRemarksCustomerLeadModel->cust_lead_id = $customer_id;
    //         $UpdateRemarksCustomerLeadModel->calling_stage = $lead_status_details;
    //         $UpdateRemarksCustomerLeadModel->next_folloup_date = $req->next_folloup;
    //         $UpdateRemarksCustomerLeadModel->cus_remarks =  $lead_status_details.'-'.$car_details.'-'.$remarks;
    //         $UpdateRemarksCustomerLeadModel->created_by = Auth::user()->name;
    //         $UpdateRemarksCustomerLeadModel->created_at = $mytime;

    //         $UpdateRemarksCustomerLeadModel->save();
    //         $lastid = $UpdateRemarksCustomerLeadModel->id;

    //     }
    //     return redirect('employee/data/view-lead')->with('success', 'Remarks Added Successfully: ' . $lastid);
    // }
    public function storeupdatedleaddata(Request $req, $id)
    {
        // 1. Validation
        $req->validate([
            'name' => 'required',
            // Ignore the current user's ID for the unique check
            'mobile_number' => 'required|numeric|digits:10|unique:customer_lead,mobile_number,' . $id,
            'remark' => 'required',
            'calling_status' => 'required', // Ensure status is selected
        ]);

        // 2. Start Transaction
        DB::beginTransaction();

        try {
            $mytime = Carbon::now('Asia/Kolkata')->format('Y-m-d H:i:s');

            // 3. Find and Update Lead
            $CustomerLeadModel = CustomerLeadModel::findOrFail($id); // Will show 404 if not found

            $CustomerLeadModel->Name = $req->name;
            $CustomerLeadModel->mobile_number = $req->mobile_number;
            $CustomerLeadModel->lead_type = $req->lead_category;
            $CustomerLeadModel->address = $req->address;
            $CustomerLeadModel->enquiry_car_details = $req->enquiry_car_details;
            $CustomerLeadModel->lead_status = $req->calling_status;
            $CustomerLeadModel->updated_by = Auth::user()->name;
            // created_at/updated_at are handled auto by Laravel, but you can force it if needed
            $CustomerLeadModel->updated_at = $mytime;

            $CustomerLeadModel->save(); // Correct method for saving changes

            // 4. Get Status Name Safely
            // specific shorthand to get a single column value
            $lead_status_name = DB::table('calling_customer_status')
                ->where('id', $req->calling_status)
                ->value('calling_status');

            // Fallback if status not found in DB
            if (!$lead_status_name) {
                $lead_status_name = 'Unknown Status';
            }

            // 5. Create Remark History
            $UpdateRemarksCustomerLeadModel = new UpdateRemarksCustomerLeadModel();

            $UpdateRemarksCustomerLeadModel->cust_lead_id = $id;
            $UpdateRemarksCustomerLeadModel->calling_stage = $lead_status_name;
            $UpdateRemarksCustomerLeadModel->next_folloup_date = $req->next_folloup;

            // Format: Status-CarDetails-Remark
            $UpdateRemarksCustomerLeadModel->cus_remarks = $lead_status_name . '-' . $req->enquiry_car_details . '-' . $req->remark;

            $UpdateRemarksCustomerLeadModel->created_by = Auth::user()->name;
            $UpdateRemarksCustomerLeadModel->created_at = $mytime;

            $UpdateRemarksCustomerLeadModel->save();
            $lastid = $UpdateRemarksCustomerLeadModel->id;

            DB::commit(); // Save everything

            return redirect('employee/data/view-lead')->with('success', 'Remarks Added Successfully: ' . $lastid);
        } catch (\Exception $e) {
            DB::rollBack(); // Undo changes if error occurs
            return back()->with('error', 'Update Failed: ' . $e->getMessage())->withInput();
        }
    }
    public function callingfollouplead()
    {
        $data['calling_lead'] = DB::table('customer_lead')
            ->join('calling_customer_status', 'customer_lead.lead_status', '=', 'calling_customer_status.id')
            ->select('customer_lead.*', 'calling_customer_status.calling_status')
            ->where('lead_asign', Auth::user()->name)
            ->where('lead_status', '1')
            ->get();

        return view('employee.data.calling-folloup-lead', $data);
    }

    public function visitfollowuplead()
    {
        $data['calling_lead'] = DB::table('customer_lead')
            ->join('calling_customer_status', 'customer_lead.lead_status', '=', 'calling_customer_status.id')
            ->select('customer_lead.*', 'calling_customer_status.calling_status')
            ->where('lead_asign', Auth::user()->name)
            ->where('lead_status', '2')
            ->get();

        return view('employee.data.visit-followup-lead', $data);
    }

    public function showcloudacalldata()
    {
        $now = Carbon::now();
        //$sevenDaysAgo = $now->copy()->subDays(2);
        $sevenDaysAgo = Carbon::now()->subDays(2)->toDateString();

        $cloud_calling_number = Auth::user()->cloud_calling_number;

        $data['cloud_call_data'] = DB::table('cloud_calling_data')
            ->where('did_number', Auth::user()->cloud_calling_number)

            ->whereDate('created_at', '>=', $sevenDaysAgo)
            ->orderBy('id', 'desc')
            ->get();

        return view('employee.cloud-call.cloud-call-data', $data);
    }
}
