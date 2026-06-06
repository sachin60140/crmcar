<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomerLeadModel;
use App\Models\ApiCloudCallModel;
use App\Models\API\JustDailModel;
use App\Models\API\QkonnectModel;
use App\Models\API\AcephoneDataModel;
use Illuminate\Support\Facades\AUTH;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Stmt\TryCatch;
use Yajra\DataTables\Facades\DataTables;

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
                'name' => $data['name'],
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

                $url = 'https://api.interakt.ai/v1/public/message/';
                $data = [
                    "countryCode"  => "+91",
                    "phoneNumber"  => $data['mobile'],
                    "campaignId"  => '4c54326f-0d3b-411f-a458-1c92df296e7e',
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

                $url = 'https://api.interakt.ai/v1/public/message/';
                $data = [
                    "countryCode"  => "+91",
                    "phoneNumber"  => $data['caller_number'],
                    "campaignId"  => '4c54326f-0d3b-411f-a458-1c92df296e7e',
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
    // public function showqkonnectdata()
    // {
    //     $now = Carbon::now();
    //     $fifteenDaysAgo = $now->copy()->subDays(15);

    //     $data['qkonnect_Data'] = DB::table('qkonnect_data')
    //         ->whereDate('created_at', '>=', $fifteenDaysAgo)
    //         ->orderBy('id', 'desc')
    //         ->get();

    //     return view('admin.cloud-calling.qkonnect-call-data', $data);
    // }

    public function showqkonnectdata(Request $request)
    {
        if ($request->ajax()) {

            // 1. Start the Query using DB Table
            $query = DB::table('qkonnect_data');

            // 2. Filter Logic
            if ($request->filled('start_date') && $request->filled('end_date')) {
                // If user filters, search specific range (ignoring 15-day limit)
                $query->whereBetween('created_at', [
                    $request->start_date . ' 00:00:00',
                    $request->end_date . ' 23:59:59'
                ]);
            } else {
                // Default: Show only last 15 days (Your original optimization)
                // You can remove this 'else' block if you want to show ALL history by default
                $fifteenDaysAgo = Carbon::now()->subDays(15);
                $query->whereDate('created_at', '>=', $fifteenDaysAgo);
            }

            // 3. Return DataTables Response
            return DataTables::of($query)
                ->addIndexColumn() // This enables DT_RowIndex
                ->editColumn('created_at', function ($row) {
                    // Format the date for display
                    return date('d-m-Y h:i:s A', strtotime($row->created_at));
                })
                ->editColumn('call_recording', function ($row) {
                    // Add the logic for the recording link
                    if (!empty($row->call_recording)) {
                        return '<a href="' . $row->call_recording . '" target="_blank" class="btn btn-sm btn-outline-primary">Recording</a>';
                    }
                    return '<span class="text-muted">N/A</span>';
                })
                ->rawColumns(['call_recording']) // Tells DataTables to render the HTML inside this column
                ->make(true);
        }

        // 4. Return View (No need to pass $data, the table loads it via AJAX)
        return view('admin.cloud-calling.qkonnect-call-data');
    }


    public function acePhoneData(Request $req)
    {
        try {
            // ==============================
            // Log raw webhook
            // ==============================
            Log::info('Acephone Webhook Raw:', $req->all());

            $data = $req->all();

            // ==============================
            // Fix wrong key (extra space issue)
            // ==============================
            if (isset($data['customer_no_with_prefix '])) {
                $data['customer_no_with_prefix'] = $data['customer_no_with_prefix '];
                unset($data['customer_no_with_prefix ']);
            }

            // ==============================
            // Normalize phone numbers (last 10 digits)
            // ==============================
            $normalizePhone = function ($number) {
                if (empty($number)) return null;
                $number = preg_replace('/[^0-9]/', '', $number);
                return strlen($number) >= 10 ? substr($number, -10) : null;
            };

            $data['caller_id_number'] = $normalizePhone($data['caller_id_number'] ?? null);
            $data['call_to_number'] = $normalizePhone($data['call_to_number'] ?? null);
            $data['customer_no_with_prefix'] = $normalizePhone($data['customer_no_with_prefix'] ?? null);

            // ==============================
            // Type Casting
            // ==============================
            $data['billsec'] = (int) ($data['billsec'] ?? 0);
            $data['duration'] = (int) ($data['duration'] ?? 0);
            $data['outbound_sec'] = (int) ($data['outbound_sec'] ?? 0);
            $data['agent_ring_time'] = (int) ($data['agent_ring_time'] ?? 0);
            $data['agent_transfer_ring_time'] = (int) ($data['agent_transfer_ring_time'] ?? 0);
            $data['customer_ring_time'] = (int) ($data['customer_ring_time'] ?? 0);

            $data['call_connected'] = filter_var($data['call_connected'] ?? false, FILTER_VALIDATE_BOOLEAN);

            // ==============================
            // Fix broadcast_lead_fields (JSON field)
            // ==============================
            if (isset($data['broadcast_lead_fields'])) {

                if (is_string($data['broadcast_lead_fields'])) {
                    $decoded = json_decode($data['broadcast_lead_fields'], true);
                    $data['broadcast_lead_fields'] = json_last_error() === JSON_ERROR_NONE ? $decoded : null;
                }

                if (!is_array($data['broadcast_lead_fields'])) {
                    $data['broadcast_lead_fields'] = null;
                }
            } else {
                $data['broadcast_lead_fields'] = null;
            }

            // ==============================
            // Convert ALL other arrays → string
            // ==============================
            foreach ($data as $key => $value) {

                if ($key === 'broadcast_lead_fields') continue;

                if (is_array($value)) {
                    $data[$key] = json_encode($value);
                }
            }

            // ==============================
            // Clean invalid placeholders
            // ==============================
            if (isset($data['campaign_name']) && str_contains($data['campaign_name'], '$')) {
                $data['campaign_name'] = null;
            }

            if (isset($data['campaign_id']) && str_contains($data['campaign_id'], '$')) {
                $data['campaign_id'] = null;
            }

            // ==============================
            // Required validation
            // ==============================
            if (empty($data['call_id'])) {
                throw new \Exception('call_id is required');
            }

            // ==============================
            // Save / Update (avoid duplicates)
            // ==============================
            $record = AcephoneDataModel::updateOrCreate(
                ['call_id' => $data['call_id']],
                $data
            );

            return response()->json([
                'status' => 'success',
                'message' => 'Data saved successfully',
                'call_id' => $record->call_id
            ], 200);
        } catch (\Exception $e) {

            Log::error('Acephone Webhook Error:', [
                'error' => $e->getMessage(),
                'payload' => $req->all()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 200);
        }
    }

    // public function showacephonedata(Request $request)
    // {
    //     // Default 45 days
    //     $from = $request->from_date
    //         ? Carbon::parse($request->from_date)->startOfDay()
    //         : now()->subDays(45)->startOfDay();

    //     $to = $request->to_date
    //         ? Carbon::parse($request->to_date)->endOfDay()
    //         : now()->endOfDay();

    //     $query = AcephoneDataModel::whereBetween('start_stamp', [$from, $to]);

    //     // Filters
    //     if ($request->filled('call_status')) {
    //         $query->where('call_status', $request->call_status);
    //     }

    //     if ($request->filled('agent')) {
    //         $query->where('answered_agent_name', $request->agent);
    //     }

    //     if ($request->filled('campaign')) {
    //         $query->where('campaign_name', $request->campaign);
    //     }

    //     $calls = $query->orderBy('start_stamp', 'desc')->get();

    //     // Summary
    //     $totalCalls = $calls->count();
    //     $answered = $calls->where('call_status', 'answered')->count();
    //     $missed = $calls->where('call_status', 'missed')->count();

    //     $conversionRate = $totalCalls > 0
    //         ? round(($answered / $totalCalls) * 100, 2)
    //         : 0;

    //     // Dropdown Data
    //     $agents = AcephoneDataModel::select('answered_agent_name')
    //         ->whereNotNull('answered_agent_name')
    //         ->distinct()->pluck('answered_agent_name');

    //     $campaigns = AcephoneDataModel::select('campaign_name')
    //         ->whereNotNull('campaign_name')
    //         ->distinct()->pluck('campaign_name');

    //     return view('admin.cloud-calling.ace-phone-data', compact(
    //         'calls',
    //         'from',
    //         'to',
    //         'totalCalls',
    //         'answered',
    //         'missed',
    //         'conversionRate',
    //         'agents',
    //         'campaigns'
    //     ));
    // }
    public function showacephonedata(Request $request)
{
    // ==============================
    // DATE FILTER (Default 45 Days)
    // ==============================
    $from = $request->from_date
        ? Carbon::parse($request->from_date)->startOfDay()
        : now()->subDays(7)->startOfDay();

    $to = $request->to_date
        ? Carbon::parse($request->to_date)->endOfDay()
        : now()->endOfDay();

    $query = AcephoneDataModel::whereBetween('start_stamp', [$from, $to]);

    // ==============================
    // FILTERS
    // ==============================

    if ($request->filled('call_status')) {
        $query->where('call_status', $request->call_status);
    }

    if ($request->filled('agent')) {
        $query->where('answered_agent_name', $request->agent);
    }

    if ($request->filled('campaign')) {
        $query->where('campaign_name', $request->campaign);
    }

    // ✅ NEW: TYPE FILTER (IMPORTANT)
    if ($request->filled('direction')) {
        $query->where('direction', $request->direction);
    }

    // ==============================
    // FETCH DATA
    // ==============================
    $calls = $query->orderBy('start_stamp', 'desc')->get();

    // ==============================
    // SUMMARY
    // ==============================
    $totalCalls = $calls->count();
    $answered = $calls->where('call_status', 'answered')->count();
    $missed = $calls->where('call_status', 'missed')->count();

    $conversionRate = $totalCalls > 0
        ? round(($answered / $totalCalls) * 100, 2)
        : 0;

    // ==============================
    // DROPDOWN DATA (FILTER BASED)
    // ==============================

    $agents = AcephoneDataModel::whereBetween('start_stamp', [$from, $to])
        ->whereNotNull('answered_agent_name')
        ->distinct()
        ->pluck('answered_agent_name');

    $campaigns = AcephoneDataModel::whereBetween('start_stamp', [$from, $to])
        ->whereNotNull('campaign_name')
        ->distinct()
        ->pluck('campaign_name');

    // ==============================
    // RETURN VIEW
    // ==============================
    return view('admin.cloud-calling.ace-phone-data', compact(
        'calls',
        'from',
        'to',
        'totalCalls',
        'answered',
        'missed',
        'conversionRate',
        'agents',
        'campaigns'
    ));
}
}
