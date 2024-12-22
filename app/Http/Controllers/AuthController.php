<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\BranchModel;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function login()
    {
        if (!empty(Auth::check())) {
            return redirect('admin/dashboard');
        }
        return view('admin.login');
    }

    public function logout(Request $request): RedirectResponse
    {
        Session::flush();

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin');
    }

    public function authlogin(Request $req)
    {
        if (Auth::attempt(['email' => $req->email, 'password' => $req->password], true)) {
            return redirect('admin/dashboard');
        } else {
            return redirect()->back()->with('error', 'Email or password is incorrect');
        }
    }
    public function dashboard()
    {
        $data['totalstock'] = DB::table('car_stock')
        ->where('stock_status','!=' ,'3')->count();
        $data['totalbranch'] = DB::table('branch')->count();
        $data['contacts'] = DB::table('customer_lead')->count();

        $data['cloud_contacts'] = DB::table('cloud_calling_data')->count();
        $data['today_cloud_contacts'] = DB::table('cloud_calling_data')->whereDate('created_at', Carbon::today())->count();

        $data['todaycontacts'] = DB::table('customer_lead')->whereDate('created_at', Carbon::today())->count();

        $data['totalvisitor'] = DB::table('visitor')->count();
        $data['totalbooking'] = DB::table('car_booking')->count();

        $data['todayvisitor'] = DB::table('visitor')->whereDate('created_at', Carbon::today())->count();

        $data['currentMonthName'] = Carbon::now()->format('F');

        $data['todaybookedcar'] = DB::table('car_booking')
                            ->whereDate('created_at', Carbon::today())
                            ->count();

        $data['currentmonthbooking'] =  DB::table('car_booking')
                             ->whereYear('created_at', Carbon::now()->year)
                            ->whereMonth('created_at', Carbon::now()->month)
                            ->count();

        $data['totaldelivary'] = DB::table('car_delivary')->count();
        $data['todaydelivary'] = DB::table('car_delivary')
                            ->whereDate('created_at', Carbon::today())
                            ->count();

        $data['currentmonthdelivary'] =  DB::table('car_delivary')
                             ->whereYear('created_at', Carbon::now()->year)
                            ->whereMonth('created_at', Carbon::now()->month)
                            ->count();
        $data['Pendingtilltoday'] = DB::table('customer_lead_remarks')
                            ->where('next_folloup_date','<=', Carbon::now())
                            ->count();
    
        $data['readyfordelivary'] = DB::table('finace_file')->where('file_status','11')->count();

        $apiURL = 'https://pgapi.vispl.in/fe/api/v1/getBalance/';
        $headers = [
            'Content-Type' => 'application/json',
            'username' => 'Y2FyNHNhbGVz',
            'password' => 'M0hxSkk=',
        ];

        $response = Http::withHeaders($headers)->get($apiURL);

        $data1 = $response;

        $data['balance'] = $data1['balance']['sms_wallet'];

        return view('admin.dashboard', $data);
    }

    public function branch()
    {
        return view('admin.add-branch');
    }

    public function addbranch(Request $req)
    {
        $req->validate([
            'branchname' => 'required',
            'mobile_number' => 'required|numeric',
            'address' => 'required',
        ]);
        $BranchModel = new BranchModel();

        $BranchModel->branch_name = $req->branchname;
        $BranchModel->branch_mobile = $req->mobile_number;
        $BranchModel->address = $req->address;

        $BranchModel->save();
        $lastid = $BranchModel->id;

        return back()->with('success', ' Branch Created Successfully: ' . $lastid);
    }
    public function viewbranch()
    {
        $data = DB::table('branch')->get();

        return view('admin.view-branch', compact('data'));
    }

    public function addemployee()
    {
        return view('admin.employee.add-employee');
    }

    public function inserempdata(Request $req)
    {
        $req->validate([
            'emp_name' => 'required',
            'emp_mobile' => 'required|numeric',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        $pass = Hash::make($req->input('password'));

        $query = DB::table('users')->insert([
            'name' => $req->input('emp_name'),
            'email' => $req->input('email'),
            'password' => $pass,
        ]);

        if ($query) {
            return back()->with('success', ' User Added Successfully: ');
        }
    }

    public function viewempdata()
    {
        $data['emplist'] = DB::table('users')
                            ->where('id','!=', '1')
                            ->get();
        return view('admin.employee.view-employee', $data);
    }

    public function editempdata($id)
    {
         $data['user_data'] =  DB::table('users')
                            ->where('id','=', $id)
                            ->first();
        return view('admin.employee.update-password',$data);
    }

    public function updateuserPassword(Request $req, $id)
    {
        $req->validate([
            'update_password' => 'required',
        ]);

        $pass = Hash::make($req->update_password);

        $UserModel = User::find($id);

        $UserModel->password = $pass;
        $UserModel->update();

        return back()->with('success', 'Password Reset Succesfully');
    }

    public function smsbalance()
    {
        $apiURL = 'https://pgapi.vispl.in/fe/api/v1/getBalance/';
        $headers = [
            'Content-Type' => 'application/json',
            'username' => 'Y2FyNHNhbGVz',
            'password' => 'M0hxSkk=',
        ];

        $response = Http::withHeaders($headers)->get($apiURL);
        $data = $response->json();

        $data1 = $response;

        //return $data->balance->sms_wallet;

        return $balance = $data1['balance']['sms_wallet'];
    }
}
