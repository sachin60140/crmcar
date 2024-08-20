<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmpModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\CustomerLeadModel;
use App\Models\VisitorModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;


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

        $sender = 'CAR4SL';
        $mob = $req->mobile_number;
        $name =$req->name;
        $auth = '3HqJI';
        $amount = $req->amount;
        $entid = '1701171869640632437';
        $temid = '1707172248683322204';
        $mob2 = [$mob];
        $mob3 = implode(',', $mob2);
        $msg = urlencode('Dear '. $name . ",\nWelcome to Car4Sales ! We're excited to help you Buy & sell your old car with ease and get the best value for it. If you have any questions or need assistance, please contact us at. 7779995656 . \nThank you for choosing us! \nBest regards,\nCar4Sales, \nMuzaffarpur, Motihari, Bakhri \nPh. 7779995656");

        $url = 'https://pgapi.vispl.in/fe/api/v1/multiSend?username=car4sales.trans&password=3HqJI&unicode=false&from=' . $sender . '&to=' . $mob . '&dltPrincipalEntityId=' . $entid . '&dltContentId=' . $temid . '&text=' . $msg;

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
            $CustomerLeadModel->lead_type = $req->lead_type;
            $CustomerLeadModel->created_by = Auth::user()->name;

            $CustomerLeadModel->save();
            $lastid = $CustomerLeadModel->id;
  
        return back()->with('success', ' Lead Added Successfully: ' .$lastid);
    }
    public function viewleaddata()
    {
        $data = DB::table('customer_lead')
                    ->where('lead_type', '=', 'Hot Lead')
                    ->where('created_by', Auth::user()->name)
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
            'mobile_number' => 'required|numeric|unique:visitor',
            'car_require' => 'required',
            'refrence' => 'required',
            'address' => 'required',
        ]);

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
}
