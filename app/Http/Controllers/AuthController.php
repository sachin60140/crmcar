<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\BranchModel;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;

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
        if (Auth::check()) {
            // Clear session ID from user record
            $user = Auth::user();
            $user->session_id = null;
            $user->save();
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin');
    }

    // public function authlogin(Request $req)
    // {
    //     if (Auth::attempt(['email' => $req->email, 'password' => $req->password], true)) {
    //         return redirect('admin/dashboard');
    //     } else {
    //         return redirect()->back()->with('error', 'Email or password is incorrect');
    //     }
    // }

    // public function authlogin(Request $req)
    // {
    //     if (Auth::attempt(['email' => $req->email, 'password' => $req->password], true)) {

    //         // 1. Regenerate session FIRST (This creates the secure, final ID)
    //         $req->session()->regenerate();

    //         $user = Auth::user();

    //         // 2. NOW get the new Session ID
    //         $currentSessionId = Session::getId();

    //         // 3. Store the correct ID in the database
    //         $user->session_id = $currentSessionId;
    //         $user->last_login_at = now();
    //         $user->last_login_ip = $req->ip();
    //         $user->save();

    //         // Store session ID in current session (optional, but fine to keep)
    //         Session::put('user_session_id', $currentSessionId);

    //         return redirect('admin/dashboard');
    //     } else {
    //         return redirect()->back()->with('error', 'Email or password is incorrect');
    //     }
    // }

    public function authlogin(Request $req)
    {
        // 1. Attempt Login
        if (Auth::attempt(['email' => $req->email, 'password' => $req->password], true)) {

            $user = Auth::user();

            // --- FIX 1: Check if value is NOT 1 (Don't use has()) ---
            if (!empty($user->session_id) && $req->force_logout != 1) {

                Auth::logout(); // Logout temporarily to prevent session fixation

                // Get Details
                $timeAgo = $user->last_login_at ? \Carbon\Carbon::parse($user->last_login_at)->diffForHumans() : 'Unknown';
                $ipAddress = $user->last_login_ip ?? 'Unknown IP';

                // --- FIX 2: Ensure JSON is returned for AJAX ---
                if ($req->ajax()) {
                    return response()->json([
                        'status' => 'conflict',
                        'message' => 'Active Session Found',
                        'details' => ['time' => $timeAgo, 'ip' => $ipAddress]
                    ]);
                }
            }

            // 2. Process Login (Force Logout or Fresh Login)
            $req->session()->regenerate();

            // Update Database with NEW Session ID
            $user->session_id = Session::getId();
            $user->last_login_at = now();
            $user->last_login_ip = $req->ip();
            $user->save(); // <--- This KICKS OUT the first user

            Session::put('user_session_id', $user->session_id);

            if ($req->ajax()) {
                return response()->json(['status' => 'success', 'redirect' => url('admin/dashboard')]);
            }
            return redirect('admin/dashboard');
        } else {
            if ($req->ajax()) {
                return response()->json(['status' => 'error', 'message' => 'Invalid Credentials']);
            }
            return redirect()->back()->with('error', 'Invalid Credentials');
        }
    }
    public function showChangePasswordForm()
    {
        return view('admin.change-password');
    }

    public function updatePassword(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'current_password' => ['required', 'string'],
            'new_password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'
            ],
        ], [
            'new_password.regex' => 'The password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
            'new_password.confirmed' => 'The new password confirmation does not match.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = Auth::user();

        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()
                ->with('error', 'Your current password is incorrect.')
                ->withInput();
        }

        // Check if new password is same as current password
        if (Hash::check($request->new_password, $user->password)) {
            return redirect()->back()
                ->with('error', 'New password cannot be the same as your current password.')
                ->withInput();
        }

        // Update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        // Logout from other devices (optional)
        // Auth::logoutOtherDevices($request->new_password);

        return redirect()->route('change.password')
            ->with('success', 'Your password has been changed successfully!');
    }


    public function dashboard()
    {
        $data['totalstock'] = DB::table('car_stock')
            ->where('stock_status', '!=', '3')->count();
        $data['totalbranch'] = DB::table('branch')->count();
        $data['contacts'] = DB::table('customer_lead')->count();

        $data['cloud_contacts'] = DB::table('cloud_calling_data')->distinct('customer_number')->count('customer_number');
        $data['today_cloud_contacts'] = DB::table('cloud_calling_data')->whereDate('created_at', Carbon::today())->count();
        $data['qkonnect_contacts'] = DB::table('qkonnect_data')->distinct('caller_number')->count('caller_number');
        $data['today_qkonnect_contacts'] = DB::table('qkonnect_data')->whereDate('created_at', Carbon::today())->count();

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
            ->where('next_folloup_date', '<=', Carbon::now())
            ->count();

        $data['readyfordelivary'] = DB::table('finace_file')->where('file_status', '11')->count();

        $apiURL = 'https://pgapi.vispl.in/fe/api/v1/getBalance/';
        $headers = [
            'Content-Type' => 'application/json',
            'username' => 'Y2FyNHNhbGVz',
            'password' => 'M0hxSkk=',
        ];

        $response = Http::withHeaders($headers)->get($apiURL);

        $data1 = $response;

        //$data['balance'] = $data1['balance']['sms_wallet'];
        $data['balance'] = '00';

        return view('admin.dashboard', $data);
    }

    public function liveDashboardKpis()
    {
        return response()->json([
            'total-stock' => Cache::remember(
                'kpi_total_stock',
                60,
                fn() => DB::table('car_stock')
                    ->where('stock_status', '!=', '3')
                    ->count()
            ),

            'total-booked' => Cache::remember(
                'kpi_total_booked',
                60,
                fn() => DB::table('car_booking')->count()
            ),

            'delivered-cars' => Cache::remember(
                'kpi_delivered_cars',
                60,
                fn() => DB::table('car_delivary')->count()
            ),

            'cloud-calls' => Cache::remember(
                'kpi_cloud_calls',
                60,
                fn() => DB::table('cloud_calling_data')
                    ->distinct()
                    ->count('customer_number')
            ),

            'total-contacts' => Cache::remember(
                'kpi_total_contacts',
                60,
                fn() => DB::table('customer_lead')->count()
            ),
        ]);
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
        $messages = [
            'emp_name.required' => 'The employee name is required.',
            'emp_name.unique' => 'The employee name already exists.',
            'emp_mobile.required' => 'The mobile number is required.',
            'emp_mobile.numeric' => 'The mobile number must be a number.',
            'email.required' => 'The email address is required.',
            'email.email' => 'The email address must be valid.',
            'email.unique' => 'The email address already exists.',
            'cloud_calling_number.numeric' => 'The cloud call number must be a number.',
            'cloud_calling_number.unique' => 'The cloud call number already exists.',
            'password.required' => 'The password is required.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.regex' => 'The password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
        ];
        $req->validate([
            'name' => 'required|unique:users',
            'emp_mobile' => 'required|numeric|digits:10',
            'email' => 'required|email|unique:users|max:255',
            'cloud_calling_number' => 'nullable|numeric|unique:users|digits:10',
            'password' => 'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
        ], $messages);


        $pass = Hash::make($req->input('password'));

        $User = new User;

        $User->name = $req->name;
        $User->email = $req->email;
        $User->cloud_calling_number = $req->cloud_calling_number;

        $User->password = $pass;
        $User->save();

        $lastid = $User->id;

        return back()->with('success', ' User Added Successfully: ');
    }

    public function viewempdata()
    {
        $data['emplist'] = DB::table('users')
            ->where('id', '!=', '1')
            ->get();
        return view('admin.employee.view-employee', $data);
    }

    public function editempdata($id)
    {
        $data['user_data'] =  DB::table('users')
            ->where('id', '=', $id)
            ->first();
        return view('admin.employee.update-password', $data);
    }

    public function updateuserPassword(Request $request, User $user)
    {
        $request->validate([
            'cloud_calling_number' => ['nullable', 'numeric', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
        ]);

        $user->cloud_calling_number = $request->cloud_calling_number;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        return back()->with('success', 'Records Updated Succesfully');
    }

    public function smsbalance()
    {
        // $apiURL = 'https://pgapi.sparc.smartping.io/fe/api/v1/getBalance/';
        // $headers = [
        //     'Content-Type' => 'application/json',
        //     'username' => 'car4sales.trans',
        //     'password' => '@i?-^ho3LBfvxk202',
        // ];

        // $response = Http::withHeaders($headers)->get($apiURL);
        // $data = $response->json();

        // return $data1 = $response;

        // //return $data->balance->sms_wallet;

        // //return $balance = $data1['balance']['sms_wallet'];
        // $message = "Dear SACHIN,\nOwnership of car BR28B1234 was transferred on 12/dec/2025. Please check mParivahan for your RC. Urgently transfer your insurance to your name.\nThanks,\nCar4Sales, Muzzfarpur";
        //$message = urlencode("प्रिय मनोज जी, \nगाड़ी संख्या BR-06-AD-1234 का स्वामित्व 12 दिसंबर 2025 को आपके नाम पर स्थानांतरित कर दिया गया है। कृपया अपना आर.सी. (रजिस्ट्रेशन प्रमाणपत्र) देखने के लिए एम-परिवहन ऐप या वेबसाइट जांचें। साथ ही, अपना वाहन बीमा भी जल्द से जल्द अपने नाम पर स्थानांतरित करवा लें। \nध्यान दें: आर.सी. प्राप्त करना एवं बीमा स्थानांतरित करवाने की ज़िम्मेदारी अब आपकी है, Car4Sales की नहीं। \nधन्यवाद, \nCar4Sales, \nमुज़फ़्फ़रपुर");
        $message = "प्रिय मनोज जी, \nगाड़ी संख्या BR-06-AD-1234 का स्वामित्व 12 दिसंबर 2025 को आपके नाम पर स्थानांतरित कर दिया गया है। कृपया अपना आर.सी. (रजिस्ट्रेशन प्रमाणपत्र) देखने के लिए एम-परिवहन ऐप या वेबसाइट जांचें। साथ ही, अपना वाहन बीमा भी जल्द से जल्द अपने नाम पर स्थानांतरित करवा लें। \nध्यान दें: आर.सी. प्राप्त करना एवं बीमा स्थानांतरित करवाने की ज़िम्मेदारी अब आपकी है, Car4Sales की नहीं। \nधन्यवाद, \nCar4Sales, \nमुज़फ़्फ़रपुर";
        $queryParams = [
            'username' => 'car4sales.trans',
            'password' => '@i?-^ho3LBfvxk202',
            'unicode' => 'true',
            'from' => 'CAR4SL',
            'text' => $message,
            'to' => '7766018777',
            'dltContentId' => '1707176519245226390',
            'dltPrincipalEntityId' => '1701171869640632437',
            'dltTelemarketerId' => '1702176485193910037'
        ];
        $response = Http::withHeaders([
            'accept' => 'application/json'
        ])->get('https://pgapi.sparc.smartping.io/fe/api/v1/send', $queryParams);

        if ($response->successful()) {
            return $response->json();
        } else {
            return $response->throw();
        }
    }
}
