<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\StockModel;
use App\Models\BookingModel;
use App\Models\CarDelivaryModel;
use App\Models\CustomerStatementModel;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DateTime;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\Facades\DataTables;
use App\Models\DtoModel;
use App\Models\DtoFileHistoryModel;
use Illuminate\Support\Str;
use App\Models\CancelledBookingModel;

class StockController extends Controller
{
    public function addstock()
    {
        $data = DB::table('branch')->orderBy('branch_name', 'asc')->get();

        return view('admin.add-stock', compact('data'));
    }
    public function insertstock(Request $req)
    {
        $req->validate([
            'branch' => 'required',
            'car_model' => 'required',
            'eng_number' => 'required|min:5|max:10',
            'chassis_number' => 'required|min:5|max:10',
            'reg_number' => 'required',
            'car_model_year' => 'required|numeric',
            'color' => 'required',
            'fuel_type' => 'required',
            'owner_sl_no' => 'required|numeric',
            'price' => 'required',
            'lastprice' => 'required',
        ]);

        $StockModel = new StockModel();

        $StockModel->branch = $req->branch;
        $StockModel->car_model = $req->car_model;
        $StockModel->reg_number = $req->reg_number;
        $StockModel->eng_number = $req->eng_number;
        $StockModel->chassis_number = $req->chassis_number;
        $StockModel->car_model_year = $req->car_model_year;
        $StockModel->color = $req->color;
        $StockModel->fuel_type = $req->fuel_type;
        $StockModel->owner_sl_no = $req->owner_sl_no;
        $StockModel->price = $req->price;
        $StockModel->lastprice = $req->lastprice;
        $StockModel->added_by = Auth::user()->name;
        $StockModel->save();
        $lastid = $StockModel->id;

        return back()->with('success', ' Stock Added Successfully: ' . $lastid);
    }

    public function viewstock()
    {
        $data['getRecord'] = StockModel::getrecord();

        return view('admin.view-stock', $data);
    }

    public function stocktransfer($id)
    {
        $data['getRecord'] = StockModel::getstock($id);

        $data['branch'] = DB::table('branch')->get();

        return view('admin.stock.stock-transfer', $data);
    }

    public function updatestock(Request $req, $id)
    {
        $req->validate([
            'branch' => 'required',
            'car_model' => 'required',
            'reg_number' => 'required',
            'eng_number' => 'required|min:5|max:10',
            'chassis_number' => 'required|min:5|max:10',
            'car_model_year' => 'required|numeric',
            'color' => 'required',
            'fuel_type' => 'required',
            'owner_sl_no' => 'required|numeric',
            'price' => 'required',
            'lastprice' => 'required',
        ]);

        $mytime = Carbon::now('Asia/Kolkata')->format('Y-m-d H:i:s');

        $StockModel = StockModel::find($id);

        $StockModel->branch = $req->branch;
        $StockModel->car_model = $req->car_model;
        $StockModel->reg_number = $req->reg_number;
        $StockModel->eng_number = $req->eng_number;
        $StockModel->chassis_number = $req->chassis_number;
        $StockModel->car_model_year = $req->car_model_year;
        $StockModel->color = $req->color;
        $StockModel->fuel_type = $req->fuel_type;
        $StockModel->owner_sl_no = $req->owner_sl_no;
        $StockModel->price = $req->price;
        $StockModel->lastprice = $req->lastprice;
        $StockModel->added_by = Auth::user()->name;

        $StockModel->updated_at = $mytime;

        $StockModel->update();

        return redirect('admin/view-stock')->with('success', 'Stock Updated Succesfully');
        //return back()->with('success', 'Stock Updated Succesfully');
    }

    public function booking()
    {
        $data['car_stock'] = DB::table('car_stock')->orderBy('reg_number', 'asc')->where('stock_status', '!=', '3')->get();

        $data['ledger'] = DB::table('ledger')->orderBy('id', 'desc')->get();

        return view('admin.add-booking', $data);
    }

    // public function storebooking(Request $req)
    // {
    //     $req->validate([
    //         'reg_number' => 'required',
    //         'booking_person' => 'required',
    //         'customer' => 'required',
    //         'total_amount' => 'required',
    //         'adv_amount' => 'required',
    //         'dp' => 'required',
    //         'finance_amount' => 'required',
    //         'remarks' => 'required',
    //     ]);
    //     $today = date('dmY');
    //     $serviceJobNumber = BookingModel::where('booking_no', 'like', $today . '%')->pluck('booking_no');
    //     do {
    //         $book_no = $today . rand(111111, 999999);
    //     } while ($serviceJobNumber->contains($book_no));

    //     $car_no = DB::table('car_stock')
    //         ->where('id', $req->reg_number)
    //         ->select('reg_number')
    //         ->first();

    //     $carreg = $car_no->reg_number;

    //     $car_model_name = DB::table('car_stock')
    //         ->where('id', $req->reg_number)
    //         ->select('car_model')
    //         ->first();
    //     $carmodel = $car_model_name->car_model;

    //     $mytime = Carbon::now('Asia/Kolkata')->format('d-m-Y H:i:s');

    //     $customerdetails=DB::table('ledger')
    //                     ->where('id', $req->customer)
    //                     ->select('mobile_number','name')
    //                     ->first(); 


    //     $paymentMode = $req->paymentMode;

    //     $BookingModel = new BookingModel();

    //     $BookingModel->car_stock_id = $req->reg_number;
    //     $BookingModel->booking_no = $book_no;
    //     $BookingModel->customer_ledger_id = $req->customer;
    //     $BookingModel->booking_person = $req->booking_person;
    //     $BookingModel->total_amount = $req->total_amount;
    //     $BookingModel->adv_amount = $req->adv_amount;
    //     $BookingModel->due_amount = $req->dp;
    //     $BookingModel->finance_amount = $req->finance_amount;
    //     $BookingModel->remarks = $req->remarks;
    //     $BookingModel->created_by = Auth::user()->name;
    //     $BookingModel->save();
    //     $lastid = $BookingModel->id;

    //     if ($lastid) {
    //         $CustomerStatementModel = new CustomerStatementModel();
    //         $CustomerStatementModel->customer_id = $req->customer;
    //         $CustomerStatementModel->payment_type = 0;
    //         $CustomerStatementModel->amount = -$req->total_amount;
    //         $CustomerStatementModel->particular = 'Amount Debited for ' . '-' . $carreg . '-' . $carmodel . '-' . $mytime;
    //         $CustomerStatementModel->created_by = Auth::user()->name;
    //         $CustomerStatementModel->save();
    //         $lastid_1 = $BookingModel->id;

    //         if ($lastid_1) {
    //             $CustomerStatementModel = new CustomerStatementModel();
    //             $CustomerStatementModel->customer_id = $req->customer;
    //             $CustomerStatementModel->payment_type = 1;
    //             $CustomerStatementModel->amount = $req->adv_amount;
    //             $CustomerStatementModel->particular = 'Amount Credited for Booking Amount for' . '-' . $carreg . '-' . $carmodel . '-' . $paymentMode . '-' . $mytime;
    //             $CustomerStatementModel->created_by = Auth::user()->name;
    //             $CustomerStatementModel->save();
    //             $lastid_1 = $BookingModel->id;
    //         }
    //     }

    //     $Stockstatus = StockModel::find($req->reg_number);
    //     $Stockstatus->stock_status = 1;
    //     $Stockstatus->update();

    //     $sender = 'CAR4SL';
    //     $mob = $customerdetails->mobile_number;
    //     $name = $customerdetails->name;
    //     $auth = '3HqJI';
    //     $entid = '1701171869640632437';
    //     $temid = '1707172716926156370';
    //     $mob2 = [$mob];
    //     $mob3 = implode(',', $mob2);
    //     $msg1 = urlencode('प्रिय '. $name . ",\nCar4Sales को चुनने के लिए धन्यवाद! हम आपकी बुक की गई गाड़ी को जल्द से जल्द डिलीवर करने का प्रयास कर रहे हैं।\nकृपया वित्तीय प्रक्रिया को पूरा करने के लिए अपने आवश्यक दस्तावेज़ शीघ्र उपलब्ध कराएं। \nधन्यवाद,\nसादर,\nCar4Sales, \nमुजफ्फरपुर, मोतिहारी, दरभंगा  \nफोन: 7779995656");

    //     $url = 'https://pgapi.vispl.in/fe/api/v1/multiSend?username=car4sales.trans&password=3HqJI&unicode=true&from=' . $sender . '&to=' . $mob . '&dltPrincipalEntityId=' . $entid . '&dltContentId=' . $temid . '&text=' . $msg1;

    //     //sms from here

    //     function SendSMS($hostUrl)
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

    //     $raa = SendSMS($url); // call function that return response with code

    //     return back()->with('success', ' Booking  Added Successfully: ' . $lastid);
    // }

    public function storebooking(Request $req)
    {
        // 1. Validate Inputs
        $req->validate([
            'reg_number'     => 'required',
            'booking_person' => 'required',
            'customer'       => 'required',
            'total_amount'   => 'required|numeric',
            'adv_amount'     => 'required|numeric',
            'dp'             => 'required|numeric',
            'finance_amount' => 'required|numeric',
            'remarks'        => 'required',
        ]);

        // =========================================================
        // DUPLICATE CHECK START
        // Criteria: Same User, Same Customer, Same Vehicle, Same Amount
        // =========================================================

        $isDuplicate = BookingModel::where('car_stock_id', $req->reg_number) // Same Vehicle
            ->where('customer_ledger_id', $req->customer)                    // Same Customer
            ->where('total_amount', $req->total_amount)                      // Same Amount
            ->where('created_by', Auth::user()->name)                        // Same User
            ->exists(); // Returns true if record exists

        if ($isDuplicate) {
            return back()->with('error', 'DUPLICATE ENTRY DETECTED: You have already created a booking for this Customer, Vehicle, and Amount.');
        }

        // Optional: Check if vehicle is already sold to ANYONE else (Extra Safety)
        $stockCheck = StockModel::find($req->reg_number);
        if ($stockCheck && $stockCheck->stock_status == 3) {
            return back()->with('error', 'VEHICLE ERROR: This vehicle is already marked as Booked/Sold.');
        }
        // =========================================================
        // DUPLICATE CHECK END
        // =========================================================

        try {
            DB::transaction(function () use ($req) {

                // Generate Booking Number
                $today = date('dmY');
                do {
                    $book_no = $today . rand(111111, 999999);
                } while (BookingModel::where('booking_no', $book_no)->exists());

                // Fetch Details
                $car_no = DB::table('car_stock')->where('id', $req->reg_number)->first();
                $customerdetails = DB::table('ledger')->where('id', $req->customer)->first();

                $carreg = $car_no->reg_number;
                $carmodel = $car_no->car_model;
                $mytime = Carbon::now('Asia/Kolkata')->format('d-m-Y H:i:s');
                $paymentMode = $req->paymentMode;

                // Save Booking
                $BookingModel = new BookingModel();
                $BookingModel->car_stock_id       = $req->reg_number;
                $BookingModel->booking_no         = $book_no;
                $BookingModel->customer_ledger_id = $req->customer;
                $BookingModel->booking_person     = $req->booking_person;
                $BookingModel->total_amount       = $req->total_amount;
                $BookingModel->adv_amount         = $req->adv_amount;
                $BookingModel->due_amount         = $req->dp;
                $BookingModel->finance_amount     = $req->finance_amount;
                $BookingModel->remarks            = $req->remarks;
                //$BookingModel->payment_mode       = $req->paymentMode;
                $BookingModel->created_by         = Auth::user()->name;
                $BookingModel->save();

                // Save Ledger (Debit)
                $CustomerStatementModel = new CustomerStatementModel();
                $CustomerStatementModel->customer_id  = $req->customer;
                $CustomerStatementModel->payment_type = 0;
                $CustomerStatementModel->amount       = -$req->total_amount;
                $CustomerStatementModel->particular   = 'Amount Debited for ' . '-' . $carreg . '-' . $carmodel . '-' . $mytime;
                $CustomerStatementModel->created_by   = Auth::user()->name;
                $CustomerStatementModel->save();

                // Save Ledger (Credit)
                $CustomerStatementModel = new CustomerStatementModel();
                $CustomerStatementModel->customer_id  = $req->customer;
                $CustomerStatementModel->payment_type = 1;
                $CustomerStatementModel->amount       = $req->adv_amount;
                $CustomerStatementModel->particular   = 'Amount Credited for Booking Amount for' . '-' . $carreg . '-' . $carmodel . '-' . $paymentMode . '-' . $mytime;
                $CustomerStatementModel->created_by   = Auth::user()->name;
                $CustomerStatementModel->save();

                // Update Stock
                $Stockstatus = StockModel::find($req->reg_number);
                if ($Stockstatus) {
                    $Stockstatus->stock_status = 1;
                    $Stockstatus->update();
                }

                // Send SMS
                // if ($customerdetails) {
                //     $this->sendBookingSMS($customerdetails);
                // }
            });

            return back()->with('success', 'Booking Added Successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    // Helper function for SMS
    public function sendBookingSMS($customerdetails)
    {
        try {
            $sender = 'CAR4SL';
            $mob = $customerdetails->mobile_number;
            $name = $customerdetails->name;
            $auth = '3HqJI';
            $entid = '1701171869640632437';
            $temid = '1707172716926156370';

            $msg1 = "प्रिय {$name},\nCar4Sales को चुनने के लिए धन्यवाद! हम आपकी बुक की गई गाड़ी को जल्द से जल्द डिलीवर करने का प्रयास कर रहे हैं।\nकृपया वित्तीय प्रक्रिया को पूरा करने के लिए अपने आवश्यक दस्तावेज़ शीघ्र उपलब्ध कराएं। \nधन्यवाद,\nसादर,\nCar4Sales, \nमुजफ्फरपुर, मोतिहारी, दरभंगा \nफोन: 7779995656";

            Http::get('https://pgapi.vispl.in/fe/api/v1/multiSend', [
                'username' => 'car4sales.trans',
                'password' => $auth,
                'unicode' => 'true',
                'from' => $sender,
                'to' => $mob,
                'dltPrincipalEntityId' => $entid,
                'dltContentId' => $temid,
                'text' => $msg1
            ]);
        } catch (\Exception $e) {
        }
    }

    // public function viewbooking()
    // {
    //     $data['carbooking'] = BookingModel::getRecord();

    //     return view('admin.booking.view-booking', $data);
    // }

    // public function viewbooking(Request $request)
    // {
    //     if ($request->ajax()) {

    //         $query = BookingModel::select(
    //                     'car_booking.id',
    //                     'car_booking.created_by',
    //                     'car_booking.booking_no', // Make sure this column exists in your DB
    //                     'car_booking.booking_person',
    //                     'car_booking.total_amount',
    //                     'car_booking.adv_amount',
    //                     'car_booking.finance_amount',
    //                     'car_booking.due_amount',
    //                     'car_booking.remarks',
    //                     'car_booking.created_at',
    //                     'ledger.name as name', 
    //                     'car_stock.car_model as carmodel', 
    //                     'car_stock.reg_number as regnumber'
    //                 )
    //                 ->leftJoin('car_stock', 'car_stock.id', '=', 'car_booking.car_stock_id')
    //                 ->leftJoin('ledger', 'ledger.id', '=', 'car_booking.customer_ledger_id')
    //                 ->where('car_booking.stock_status', 1);

    //         // --- DATE FILTER LOGIC ---
    //         if ($request->filled('from_date') && $request->filled('to_date')) {
    //             $query->whereDate('car_booking.created_at', '>=', $request->from_date)
    //                   ->whereDate('car_booking.created_at', '<=', $request->to_date);
    //         } else {
    //             $query->whereDate('car_booking.created_at', '>=', Carbon::now()->subDays(90));
    //         }

    //         // --- SORTING ---
    //         $query->orderBy('car_booking.id', 'desc'); 

    //         return DataTables::of($query)
    //             ->addIndexColumn()
    //             ->editColumn('created_at', function($row){
    //                 return date('d-M-Y', strtotime($row->created_at));
    //             })
    //             // Use Safe Null Checks (?? '-')
    //             ->addColumn('name', function($row){ return $row->name ?? '-'; })

    //             // --- FIX IS HERE: Return booking_no, NOT name ---
    //             ->addColumn('booking_no', function($row){ return $row->booking_no ?? '-'; }) 
    //             // ------------------------------------------------

    //             ->addColumn('regnumber', function($row){ return $row->regnumber ?? '-'; })
    //             ->addColumn('carmodel', function($row){ return $row->carmodel ?? '-'; })
    //             ->addColumn('action', function($row){
    //                 $printUrl = url('/admin/print-booking-pdf/'.$row->id);
    //                 $delUrl = url('/admin/delivary/add-delivary/'.$row->id);
    //                 return '<div class="d-flex gap-1">
    //                             <a href="'.$printUrl.'" class="badge bg-primary">Print</a>
    //                             <a href="'.$delUrl.'" class="badge bg-success">Delivery</a>
    //                         </div>';
    //             })
    //             ->rawColumns(['action'])
    //             ->make(true);
    //     }

    //     // --- CRITICAL: Return the view for normal page load ---
    //     return view('admin.booking.view-booking');
    // }    

    // public function viewbooking(Request $request)
    // {
    //     if ($request->ajax()) {
    //         // 1. Build the base query with Joins
    //         $query = BookingModel::select(
    //             'car_booking.id',
    //             'car_booking.created_by',
    //             'car_booking.booking_no',
    //             'car_booking.booking_person',
    //             'car_booking.total_amount',
    //             'car_booking.adv_amount',
    //             'car_booking.finance_amount',
    //             'car_booking.due_amount',
    //             'car_booking.remarks',
    //             'car_booking.created_at',
    //             'ledger.name as name',
    //             'car_stock.car_model as carmodel',
    //             'car_stock.reg_number as regnumber'
    //         )
    //             ->leftJoin('car_stock', 'car_stock.id', '=', 'car_booking.car_stock_id')
    //             ->leftJoin('ledger', 'ledger.id', '=', 'car_booking.customer_ledger_id')
    //             ->where('car_booking.stock_status', 1);

    //         // 2. Date Filter Logic
    //         if ($request->filled('from_date') && $request->filled('to_date')) {
    //             $query->whereDate('car_booking.created_at', '>=', $request->from_date)
    //                 ->whereDate('car_booking.created_at', '<=', $request->to_date);
    //         }

    //         // 3. Initialize DataTables
    //         return DataTables::of($query)
    //             ->addIndexColumn()
    //             ->editColumn('created_at', function ($row) {
    //                 return $row->created_at ? date('d-M-Y', strtotime($row->created_at)) : '';
    //             })
    //             // Column specific formatting if needed
    //             ->addColumn('action', function ($row) {
    //                 $printUrl = url('/admin/print-booking-pdf/' . $row->id);
    //                 $delUrl = url('/admin/delivary/add-delivary/' . $row->id);
    //                 return '<div class="d-flex gap-1">
    //                                     <a href="' . $printUrl . '" class="badge bg-primary">Print</a>
    //                                     <a href="' . $delUrl . '" class="badge bg-success">Delivery</a>
    //                                 </div>';
    //             })
    //             ->rawColumns(['action'])
    //             ->make(true);
    //     }

    //     return view('admin.booking.view-booking');
    // }

    // public function viewbooking(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $query = BookingModel::select(
    //             'car_booking.id',
    //             'car_booking.created_by',
    //             'car_booking.booking_no',
    //             'car_booking.booking_person',
    //             'car_booking.total_amount',
    //             'car_booking.adv_amount',
    //             'car_booking.finance_amount',
    //             'car_booking.due_amount',
    //             'car_booking.remarks',
    //             'car_booking.created_at',
    //             'ledger.name as name',
    //             'car_stock.car_model as carmodel',
    //             'car_stock.reg_number as regnumber'
    //         )
    //             ->leftJoin('car_stock', 'car_stock.id', '=', 'car_booking.car_stock_id')
    //             ->leftJoin('ledger', 'ledger.id', '=', 'car_booking.customer_ledger_id')
    //             ->where('car_booking.stock_status', 1);

    //         // --- IMPROVED DATE FILTER LOGIC ---
    //         if ($request->filled('from_date') && $request->filled('to_date')) {
    //             // Filter by user selected dates
    //             $query->whereBetween('car_booking.created_at', [
    //                 $request->from_date . ' 00:00:00',
    //                 $request->to_date . ' 23:59:59'
    //             ]);
    //         } else {
    //             // DEFAULT: Last 90 Days if no dates provided
    //             $query->where('car_booking.created_at', '>=', now()->subDays(90));
    //         }

    //         return DataTables::of($query)
    //             ->addIndexColumn()
    //             ->filter(function ($instance) use ($request) {
    //                 if ($request->has('search') && !empty($request->get('search')['value'])) {
    //                     $keyword = $request->get('search')['value'];
    //                     $instance->where(function ($q) use ($keyword) {
    //                         $q->where('car_booking.booking_no', 'LIKE', "%$keyword%")
    //                             ->orWhere('ledger.name', 'LIKE', "%$keyword%")
    //                             ->orWhere('car_stock.reg_number', 'LIKE', "%$keyword%");
    //                     });
    //                 }
    //             })
    //             ->editColumn('created_at', function ($row) {
    //                 return $row->created_at ? date('d-M-Y', strtotime($row->created_at)) : '';
    //             })
    //             ->addColumn('action', function ($row) {
    //                 // Generate the URL for Print and Delivery
    //                 $printUrl = url('/admin/print-booking-pdf/' . $row->id);
    //                 $deliveryUrl = url('/admin/delivary/add-delivary/' . $row->id);

    //                 return '<div class="d-flex gap-1">
    //         <a href="' . $printUrl . '" class="badge bg-primary text-decoration-none">Print</a>

    //         <a href="' . $deliveryUrl . '" class="badge bg-success text-decoration-none">Delivery</a>

    //         <button type="button" 
    //             class="badge bg-danger border-0 btn-cancel-booking" 
    //             data-id="' . $row->id . '">
    //             Cancel
    //         </button>
    //     </div>';
    //             })
    //             ->rawColumns(['action'])
    //             ->make(true);
    //     }

    //     return view('admin.booking.view-booking');
    // }
    public function viewbooking(Request $request)
    {
        if ($request->ajax()) {
            $query = BookingModel::select(
                'car_booking.id',
                'car_booking.created_by',
                'car_booking.booking_no',
                'car_booking.booking_person',
                'car_booking.total_amount',
                'car_booking.adv_amount',
                'car_booking.finance_amount',
                'car_booking.due_amount',
                'car_booking.remarks',
                'car_booking.created_at',
                'ledger.name as name',
                'car_stock.car_model as carmodel',
                'car_stock.reg_number as regnumber'
            )
                ->leftJoin('car_stock', 'car_stock.id', '=', 'car_booking.car_stock_id')
                ->leftJoin('ledger', 'ledger.id', '=', 'car_booking.customer_ledger_id')
                ->where('car_booking.stock_status', 1);

            // --- DATE FILTERS ---
            if ($request->filled('from_date') && $request->filled('to_date')) {
                $query->whereBetween('car_booking.created_at', [
                    $request->from_date . ' 00:00:00',
                    $request->to_date . ' 23:59:59'
                ]);
            } else {
                $query->where('car_booking.created_at', '>=', now()->subDays(90));
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->filter(function ($instance) use ($request) {
                    if ($request->has('search') && !empty($request->get('search')['value'])) {
                        $keyword = $request->get('search')['value'];
                        $instance->where(function ($q) use ($keyword) {
                            $q->where('car_booking.booking_no', 'LIKE', "%$keyword%")
                                ->orWhere('ledger.name', 'LIKE', "%$keyword%")
                                ->orWhere('car_stock.reg_number', 'LIKE', "%$keyword%");
                        });
                    }
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at ? date('d-M-Y', strtotime($row->created_at)) : '';
                })
                ->addColumn('action', function ($row) {
                    // URLs
                    $printUrl = url('/admin/print-booking-pdf/' . $row->id);
                    $deliveryUrl = url('/admin/delivary/add-delivary/' . $row->id);

                    // Data for Modal (Handle nulls to avoid errors)
                    $customerName = $row->name ?? '';
                    $regNumber = $row->regnumber ?? '';
                    $totalAmount = $row->total_amount ?? 0;
                    $advAmount = $row->adv_amount ?? 0;

                    return '<div class="d-flex gap-1">
                        <a href="' . $printUrl . '" class="badge bg-primary text-decoration-none">Print</a>
                        
                        <a href="' . $deliveryUrl . '" class="badge bg-success text-decoration-none">Delivery</a>
                        
                        <button type="button" 
                            class="badge bg-danger border-0 btn-cancel-booking" 
                            data-id="' . $row->id . '" 
                            data-customer="' . htmlspecialchars($customerName) . '"
                            data-reg="' . htmlspecialchars($regNumber) . '"
                            data-sell="' . $totalAmount . '"
                            data-booking="' . $advAmount . '">
                            Cancel
                        </button>
                    </div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.booking.view-booking');
    }

    public function exportBookings(Request $request)
    {
        // 1. REUSE QUERY LOGIC (Same as viewbooking)
        $query = BookingModel::select(
            'car_booking.created_by',
            'car_booking.booking_no',
            'ledger.name as customer_name',
            'car_stock.reg_number',
            'car_stock.car_model',
            'car_booking.booking_person',
            'car_booking.total_amount',
            'car_booking.adv_amount',
            'car_booking.finance_amount',
            'car_booking.due_amount',
            'car_booking.remarks',
            'car_booking.created_at'
        )
            ->leftJoin('car_stock', 'car_stock.id', '=', 'car_booking.car_stock_id')
            ->leftJoin('ledger', 'ledger.id', '=', 'car_booking.customer_ledger_id')
            ->where('car_booking.stock_status', 1);

        // 2. APPLY DATE FILTERS
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('car_booking.created_at', [
                $request->from_date . ' 00:00:00',
                $request->to_date . ' 23:59:59'
            ]);
        } else {
            $query->where('car_booking.created_at', '>=', now()->subDays(90));
        }

        // 3. APPLY SEARCH FILTER
        if ($request->filled('search')) {
            $keyword = $request->search;
            $query->where(function ($q) use ($keyword) {
                $q->where('car_booking.booking_no', 'LIKE', "%$keyword%")
                    ->orWhere('ledger.name', 'LIKE', "%$keyword%")
                    ->orWhere('car_stock.reg_number', 'LIKE', "%$keyword%");
            });
        }

        // Get ALL data (no pagination)
        $bookings = $query->orderBy('car_booking.id', 'desc')->get();

        // 4. STREAM DOWNLOAD
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=All_Bookings_" . date('Y-m-d_H-i') . ".csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function () use ($bookings) {
            $file = fopen('php://output', 'w');

            // CSV Headers
            fputcsv($file, [
                'Created By',
                'Booking No',
                'Customer Name',
                'Reg No',
                'Model',
                'Booking Person',
                'Total Amount',
                'Adv Amount',
                'Finance',
                'Due Amount',
                'Remarks',
                'Date'
            ]);

            // CSV Rows
            foreach ($bookings as $row) {
                fputcsv($file, [
                    $row->created_by,
                    $row->booking_no,
                    $row->customer_name,
                    $row->reg_number,
                    $row->car_model,
                    $row->booking_person,
                    $row->total_amount,
                    $row->adv_amount,
                    $row->finance_amount,
                    $row->due_amount,
                    $row->remarks,
                    $row->created_at ? date('d-M-Y', strtotime($row->created_at)) : ''
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
    public function trafficchallan()
    {
        return view('admin.traffic-challan');
    }

    public function bookinpdf($id)
    {
        // 1. Fetch the data
        $carBooking = BookingModel::getRecordpdf($id);

        // 2. Safety Check: If no record is found, redirect back or show error
        // This prevents "Undefined array key 0" errors
        if (empty($carBooking) || count($carBooking) == 0) {
            return redirect()->back()->with('error', 'Booking record not found.');
        }

        // 3. Extract Registration Number safely for the filename
        // We check if it's an Object (->) or Array ([]) just in case
        $firstRecord = $carBooking[0];
        $rawRegNumber = is_object($firstRecord) ? $firstRecord->regnumber : $firstRecord['regnumber'];

        // 4. Clean the filename
        // Converts "BR 06 PB 1234" to "br-06-pb-1234.pdf" (prevents browser download errors)
        $fileName = Str::slug($rawRegNumber) . '.pdf';

        // 5. Prepare data for the view
        $data['carbooking'] = $carBooking;

        // 6. Generate PDF
        // Note: Ensure your view file name matches exactly (case-sensitive on Linux servers)
        // I corrected 'bookinPdf' to 'bookingPdf' assuming that is the correct spelling
        $pdf = Pdf::loadView('admin.booking.bookinPdf', $data);

        // Optional: Explicitly set paper size (matches the design provided earlier)
        $pdf->setPaper('a4', 'portrait');

        return $pdf->download($fileName);
    }
    //     public function bookinpdf($id)
    // {
    //     $data['carbooking'] = BookingModel::getRecordpdf($id);

    //     if (empty($data['carbooking'])) {
    //         abort(404, 'Booking not found');
    //     }

    //     $regnumber = $data['carbooking'][0]->regnumber ?? 'booking';

    //     // Configure DomPDF for single page
    //     $pdf = Pdf::loadView('admin.booking.bookinPdf', $data);

    //     // Set paper size and orientation
    //     $pdf->setPaper('A4', 'portrait');

    //     // Set options for single page output
    //     $pdf->setOptions([
    //         'defaultFont' => 'dejavu sans',
    //         'isHtml5ParserEnabled' => true,
    //         'isRemoteEnabled' => false, // Set to true if using external images
    //         'isPhpEnabled' => true,
    //         'dpi' => 96,
    //         'defaultPaperSize' => 'a4',
    //         'defaultPaperOrientation' => 'portrait',
    //         'fontHeightRatio' => 0.8,
    //         'margin_top' => 15,
    //         'margin_right' => 15,
    //         'margin_bottom' => 15,
    //         'margin_left' => 15,
    //     ]);

    //     return $pdf->download($regnumber . '.pdf');
    // }


    public function adddelivary(Request $req, $id)
    {
        $data['carbooking'] = BookingModel::getRecordpdf($id);

        $regnumber = $data['carbooking'][0]['regnumber'];
        $data['financer'] = DB::table('financer_details')->orderBy('financer_name', 'asc')->get();

        return view('admin.delivary.add-delivary', $data);
    }

    // public function insertdelivary(Request $req)
    // {
    //     $req->validate([
    //         'booking_id' => 'required|numeric',
    //         'booking_date' => 'required|date',
    //         'booking_person' => 'required',
    //         'name' => 'required',
    //         'father_name' => 'required',
    //         'mobile' => 'required|min_digits:10|max_digits:10',
    //         'aadhar' => 'required|min_digits:10|max_digits:12',
    //         'pan_card' => 'required|size:10',
    //         'city' => 'required',
    //         'address' => 'required',
    //         'reg_number' => 'required',
    //         'owner_sl_no' => 'required',
    //         'model_name' => 'required',
    //         'model_year' => 'required',
    //         'car_color' => 'required',
    //         'eng_number' => 'required',
    //         'chassis_number' => 'required',
    //         'sell_amount' => 'required',
    //         'booking_amount' => 'required',
    //         'finance_amount' => 'required',
    //         'dp' => 'required',
    //         'financer' => 'required',
    //         'remarks' => 'required',
    //         'electricle_work' => 'required',
    //         'ac_work_status' => 'required',
    //         'suspenstion_status' => 'required',
    //         'engine_status' => 'required',
    //         'starting_status' => 'required',
    //         'stepny_status' => 'required',
    //         'tools_kit_status' => 'required',
    //         'inspection_by' => 'required',
    //         'pdi_image' => 'required|image|mimes:jpg,png,jpeg,pdf|max:10240',
    //         'pdi_remarks' => 'required',
    //     ]);

    //     $mytime = Carbon::now('Asia/Kolkata')->format('d-m-Y H:i:s');

    //     $delivered_car = DB::table('car_delivary')
    //         ->where('reg_number', $req->reg_number)
    //         ->first();

    //     if ($delivered_car) {
    //         return redirect('admin/view-booking')->with('error', 'Selected Car Already Delivered');
    //     } else {
    //         $user = DB::table('car_booking')
    //             ->where('booking_no', $req->booking_id)
    //             ->first();
    //         $customer_id = $user->customer_ledger_id;

    //         $CarDelivaryModel = new CarDelivaryModel();

    //         $CarDelivaryModel->booking_id = $req->booking_id;
    //         $CarDelivaryModel->booking_date = $req->booking_date;
    //         $CarDelivaryModel->booking_person = $req->booking_person;
    //         $CarDelivaryModel->name = $req->name;
    //         $CarDelivaryModel->father_name = $req->father_name;
    //         $CarDelivaryModel->mobile = $req->mobile;
    //         $CarDelivaryModel->aadhar = $req->aadhar;
    //         $CarDelivaryModel->pan_card = $req->pan_card;
    //         $CarDelivaryModel->city = $req->city;
    //         $CarDelivaryModel->address = $req->address;
    //         $CarDelivaryModel->reg_number = $req->reg_number;
    //         $CarDelivaryModel->owner_sl_no = $req->owner_sl_no;
    //         $CarDelivaryModel->model_name = $req->model_name;
    //         $CarDelivaryModel->model_year = $req->model_year;
    //         $CarDelivaryModel->car_color = $req->car_color;
    //         $CarDelivaryModel->eng_number = $req->eng_number;
    //         $CarDelivaryModel->chassis_number = $req->chassis_number;
    //         $CarDelivaryModel->sell_amount = $req->sell_amount;
    //         $CarDelivaryModel->booking_amount = $req->booking_amount;
    //         $CarDelivaryModel->finance_amount = $req->finance_amount;
    //         $CarDelivaryModel->dp = $req->dp;
    //         $CarDelivaryModel->paymentMode = $req->paymentMode;
    //         $CarDelivaryModel->financer = $req->financer;
    //         $CarDelivaryModel->remarks = $req->remarks;
    //         $CarDelivaryModel->electricle_work = $req->electricle_work;
    //         $CarDelivaryModel->ac_work_status = $req->ac_work_status;
    //         $CarDelivaryModel->suspenstion_status = $req->suspenstion_status;
    //         $CarDelivaryModel->engine_status = $req->engine_status;
    //         $CarDelivaryModel->starting_status = $req->starting_status;
    //         $CarDelivaryModel->stepny_status = $req->stepny_status;
    //         $CarDelivaryModel->tools_kit_status = $req->tools_kit_status;
    //         $CarDelivaryModel->inspection_by = $req->inspection_by;
    //         if ($req->hasFile('pdi_image')) {
    //             $d = new DateTime();
    //             $nd = $d->format("YmdHisv");
    //             $regnumber = $req->reg_number;
    //             $pdfext = $req->file('pdi_image')->getClientOriginalExtension();

    //             $uniqueFileName = uniqid() . '_' . time() . '_' . $regnumber . '.' . $pdfext;

    //             $file = $req->file('pdi_image');
    //             $file->move('upload/pdi', $uniqueFileName);

    //             $CarDelivaryModel->pdi_image = $uniqueFileName;
    //         }

    //         $CarDelivaryModel->pdi_remarks = $req->pdi_remarks;

    //         $CarDelivaryModel->added_by = Auth::user()->name;
    //         $CarDelivaryModel->save();
    //         $lastid = $CarDelivaryModel->id;

    //         if ($lastid) {
    //             $CustomerStatementModel = new CustomerStatementModel();
    //             $CustomerStatementModel->customer_id = $customer_id;
    //             $CustomerStatementModel->payment_type = 1;
    //             $CustomerStatementModel->amount = $req->dp;
    //             $CustomerStatementModel->particular = 'Amount Credited for Down Payment for' . '-' . $req->reg_number . '-' . $req->model_name . '-' . $req->paymentMode . '-' . $mytime;
    //             $CustomerStatementModel->created_by = Auth::user()->name;
    //             $CustomerStatementModel->save();
    //             $lastid_1 = $CustomerStatementModel->id;
    //         }

    //         if ($lastid_1) {
    //             DB::table('car_booking')
    //                 ->where('booking_no', $req->booking_id)
    //                 ->update(['stock_status' => 3]);

    //             DB::table('car_stock')
    //                 ->where('reg_number', $req->reg_number)
    //                 ->update(['stock_status' => 3]);
    //         }

    //         return redirect('admin/view-booking')->with('success', 'Delivary Added Succesfully ' . $lastid);
    //     }
    // }

    // public function insertdelivary(Request $req)
    // {
    //     // 1. Validation
    //     $validatedData = $req->validate([
    //         'booking_id'      => 'required|numeric',
    //         'booking_date'    => 'required|date',
    //         'booking_person'  => 'required',
    //         'name'            => 'required',
    //         'father_name'     => 'required',
    //         'mobile'          => 'required|digits:10', // Optimized from min/max
    //         'aadhar'          => 'required|digits_between:10,12',
    //         'pan_card'        => 'required|size:10',
    //         'city'            => 'required',
    //         'address'         => 'required',
    //         'reg_number'      => 'required',
    //         'owner_sl_no'     => 'required',
    //         'model_name'      => 'required',
    //         'model_year'      => 'required',
    //         'car_color'       => 'required',
    //         'eng_number'      => 'required',
    //         'chassis_number'  => 'required',
    //         'sell_amount'     => 'required|numeric',
    //         'booking_amount'  => 'required|numeric',
    //         'finance_amount'  => 'required|numeric',
    //         'dp'              => 'required|numeric',
    //         'financer'        => 'nullable', // Changed to nullable if not always present
    //         'remarks'         => 'required',
    //         'electricle_work' => 'required',
    //         'ac_work_status'  => 'required',
    //         'suspenstion_status' => 'required',
    //         'engine_status'   => 'required',
    //         'starting_status' => 'required',
    //         'stepny_status'   => 'required',
    //         'tools_kit_status' => 'required',
    //         'inspection_by'   => 'required',
    //         'pdi_image'       => 'required|image|mimes:jpg,png,jpeg,pdf|max:10240',
    //         'pdi_remarks'     => 'required',
    //         'paymentMode'     => 'required',
    //     ]);

    //     // 2. Check for Duplicate Delivery
    //     // Ideally, add 'unique:car_delivary,reg_number' to validation rules, 
    //     // but we keep this manual check to redirect with a specific error message.
    //     $isDelivered = DB::table('car_delivary')
    //         ->where('reg_number', $req->reg_number)
    //         ->exists();

    //     if ($isDelivered) {
    //         return redirect('admin/view-booking')->with('error', 'Selected Car Already Delivered');
    //     }

    //     // 3. Begin Database Transaction
    //     try {
    //         DB::transaction(function () use ($req, $validatedData) {

    //             // A. Handle File Upload
    //             if ($req->hasFile('pdi_image')) {
    //                 $file = $req->file('pdi_image');
    //                 $filename = uniqid() . '_' . time() . '_' . $req->reg_number . '.' . $file->getClientOriginalExtension();
    //                 $file->move(public_path('upload/pdi'), $filename);

    //                 // Add filename to data array
    //                 $validatedData['pdi_image'] = $filename;
    //             }

    //             // B. Add Meta Data
    //             $validatedData['added_by'] = Auth::user()->name;
    //             // Ensure pdi_remarks is set (even if null)
    //             $validatedData['pdi_remarks'] = $req->pdi_remarks;

    //             // C. Create Delivery Record (Mass Assignment)
    //             $delivery = CarDelivaryModel::create($validatedData);

    //             // D. Get Customer Ledger ID
    //             $booking = DB::table('car_booking')
    //                 ->where('booking_no', $req->booking_id)
    //                 ->select('customer_ledger_id')
    //                 ->first();

    //             if ($booking) {
    //                 // E. Create Customer Statement
    //                 $particulars = sprintf(
    //                     'Amount Credited for Down Payment for - %s - %s - %s - %s',
    //                     $req->reg_number,
    //                     $req->model_name,
    //                     $req->paymentMode,
    //                     Carbon::now('Asia/Kolkata')->format('d-m-Y H:i:s')
    //                 );

    //                 CustomerStatementModel::create([
    //                     'customer_id'  => $booking->customer_ledger_id,
    //                     'payment_type' => 1, // Credit
    //                     'amount'       => $req->dp,
    //                     'particular'   => $particulars,
    //                     'created_by'   => Auth::user()->name,
    //                 ]);

    //                 // F. Update Stock & Booking Status
    //                 // Using 3 as 'Delivered' status
    //                 DB::table('car_booking')
    //                     ->where('booking_no', $req->booking_id)
    //                     ->update(['stock_status' => 3]);

    //                 DB::table('car_stock')
    //                     ->where('reg_number', $req->reg_number)
    //                     ->update(['stock_status' => 3]);
    //             }
    //         });

    //         // 4. Success Response
    //         // Since we are outside the transaction scope now, we can't get the ID easily unless we return it from the closure, 
    //         // but typically a success message is enough.
    //         return redirect('admin/view-booking')->with('success', 'Delivery Details Added Successfully.');
    //     } catch (\Exception $e) {
    //         // 5. Error Response
    //         // If anything fails inside the transaction, it rolls back and comes here.
    //         return back()->with('error', 'Something went wrong: ' . $e->getMessage())->withInput();
    //     }
    // }

    public function insertdelivary(Request $req)
    {
        // 1. Validation
        $validatedData = $req->validate([
            'booking_id'      => 'required|numeric',
            'booking_date'    => 'required|date',
            'booking_person'  => 'required',
            'name'            => 'required',
            'father_name'     => 'required',
            'mobile'          => 'required|digits:10',
            'aadhar'          => 'required|digits_between:10,12',
            'pan_card'        => 'required|size:10',
            'city'            => 'required',
            'address'         => 'required',
            'reg_number'      => 'required',
            'owner_sl_no'     => 'required',
            'model_name'      => 'required',
            'model_year'      => 'required',
            'car_color'       => 'required',
            'eng_number'      => 'required',
            'chassis_number'  => 'required',
            'sell_amount'     => 'required|numeric',
            'booking_amount'  => 'required|numeric',
            'finance_amount'  => 'required|numeric',
            'dp'              => 'required|numeric',
            'financer'        => 'nullable',
            'remarks'         => 'required',
            'electricle_work' => 'required',
            'ac_work_status'  => 'required',
            'suspenstion_status' => 'required',
            'engine_status'   => 'required',
            'starting_status' => 'required',
            'stepny_status'   => 'required',
            'tools_kit_status' => 'required',
            'inspection_by'   => 'required',
            'pdi_image'       => 'required|image|mimes:jpg,png,jpeg,pdf|max:10240',
            'pdi_remarks'     => 'required',
            'paymentMode'     => 'required',
        ]);

        // 2. Check for Duplicate Delivery
        $isDelivered = DB::table('car_delivary')
            ->where('reg_number', $req->reg_number)
            ->exists();

        if ($isDelivered) {
            return redirect('admin/view-booking')->with('error', 'Selected Car Already Delivered');
        }

        // 3. Begin Database Transaction
        try {
            DB::transaction(function () use ($req, $validatedData) {

                // A. Handle File Upload
                if ($req->hasFile('pdi_image')) {
                    $file = $req->file('pdi_image');
                    $filename = uniqid() . '_' . time() . '_' . $req->reg_number . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('upload/pdi'), $filename);
                    $validatedData['pdi_image'] = $filename;
                }

                // B. Add Meta Data
                $validatedData['added_by'] = Auth::user()->name;
                $validatedData['pdi_remarks'] = $req->pdi_remarks;

                // C. Create Delivery Record
                $delivery = CarDelivaryModel::create($validatedData);

                // ==========================================================
                // D. AUTO INSERT INTO DTO DISPATCH TABLE
                // ==========================================================
                $dto = new DtoModel;
                $dto->reg_number              = $req->reg_number;
                $dto->purchaser_name          = $req->name;        // Mapped from Delivery Name
                $dto->Purchaser_mobile_number = $req->mobile;      // Mapped from Delivery Mobile
                $dto->financer                = $req->financer;    // Mapped from Delivery Financer

                // Status explicitly requested
                $dto->status                  = 'Work Not Started';

                // Setting defaults for fields that might be required in DB but not available yet
                $dto->vendor_name             = 'Pending';
                $dto->vendor_mobile_number    = '0000000000';
                $dto->remarks                 = 'Auto Generated from Delivery';
                $dto->created_by              = Auth::user()->name;
                $dto->save();

                // Create Initial History for DTO
                $dtoHistory = new DtoFileHistoryModel;
                $dtoHistory->dto_file_id = $dto->id;
                $dtoHistory->status      = 'Work Not Started';
                $dtoHistory->remarks     = 'Auto Generated from Delivery';
                $dtoHistory->created_by  = Auth::user()->name;
                $dtoHistory->save();
                // ==========================================================

                // E. Get Customer Ledger ID
                $booking = DB::table('car_booking')
                    ->where('booking_no', $req->booking_id)
                    ->select('customer_ledger_id')
                    ->first();

                if ($booking) {
                    // F. Create Customer Statement
                    $particulars = sprintf(
                        'Amount Credited for Down Payment for - %s - %s - %s - %s',
                        $req->reg_number,
                        $req->model_name,
                        $req->paymentMode,
                        Carbon::now('Asia/Kolkata')->format('d-m-Y H:i:s')
                    );

                    CustomerStatementModel::create([
                        'customer_id'  => $booking->customer_ledger_id,
                        'payment_type' => 1, // Credit
                        'amount'       => $req->dp,
                        'particular'   => $particulars,
                        'created_by'   => Auth::user()->name,
                    ]);

                    // G. Update Stock & Booking Status
                    DB::table('car_booking')
                        ->where('booking_no', $req->booking_id)
                        ->update(['stock_status' => 3]);

                    DB::table('car_stock')
                        ->where('reg_number', $req->reg_number)
                        ->update(['stock_status' => 3]);
                }
            });

            return redirect('admin/view-booking')->with('success', 'Delivery Details Added & DTO File Initiated Successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong: ' . $e->getMessage())->withInput();
        }
    }
    public function insertCancelBooking(Request $request)
    {
        // 1. Validate
        $request->validate([
            'id' => 'required',
            'cancel_reason' => 'required|string'
        ]);

        DB::beginTransaction();

        try {
            // 2. Find the Booking
            $booking = BookingModel::find($request->id);

            if (!$booking) {
                return response()->json(['status' => 'error', 'message' => 'Booking not found.']);
            }

            $carStockId = $booking->car_stock_id;
            $customerId = $booking->customer_ledger_id;

            // ---------------------------------------------------------
            // STOCK LOGIC: Check count BEFORE cancelling the booking
            // ---------------------------------------------------------
            $totalActiveBookings = BookingModel::where('car_stock_id', $carStockId)
                ->where('stock_status', 1)
                ->count();

            // If this is the ONLY booking, release the stock to '2' (IN-Stock)
            if ($totalActiveBookings == 1) {
                DB::table('car_stock')
                    ->where('id', $carStockId)
                    ->update(['stock_status' => 2]);
            }

            // ---------------------------------------------------------
            // LEDGER REVERSAL (Credit/Debit Adjustments)
            // ---------------------------------------------------------
            $carDetails = DB::table('car_stock')->where('id', $carStockId)->first();
            $carInfo = $carDetails ? ($carDetails->reg_number . '-' . $carDetails->car_model) : 'Unknown Car';

            // 1. Reverse "Total Amount"
            $ledger1 = new CustomerStatementModel();
            $ledger1->customer_id  = $customerId;
            $ledger1->payment_type = 1; // Credit
            $ledger1->amount       = $booking->total_amount;
            $ledger1->particular   = 'Booking Cancelled - Reversal of Total Amount for ' . $carInfo . ' | ' . $request->cancel_reason;
            $ledger1->created_by   = Auth::user()->name;
            $ledger1->save();

            // 2. Reverse "Advance Amount"
            $ledger2 = new CustomerStatementModel();
            $ledger2->customer_id  = $customerId;
            $ledger2->payment_type = 0; // Debit
            $ledger2->amount       = -$booking->adv_amount;
            $ledger2->particular   = 'Booking Cancelled - Refund/Reversal of Advance for ' . $carInfo . ' | ' . $request->cancel_reason;
            $ledger2->created_by   = Auth::user()->name;
            $ledger2->save();

            // ---------------------------------------------------------
            // NEW: SAVE TO CANCELLED BOOKINGS TABLE
            // ---------------------------------------------------------
            $cancelRecord = new CancelledBookingModel();
            $cancelRecord->booking_id    = $booking->id;
            $cancelRecord->booking_no    = $booking->booking_no;
            $cancelRecord->customer_id   = $customerId;
            $cancelRecord->car_stock_id  = $carStockId;
            $cancelRecord->total_amount  = $booking->total_amount;
            $cancelRecord->refund_amount = $booking->adv_amount; // Amount refunded to customer
            $cancelRecord->cancel_reason = $request->cancel_reason;
            $cancelRecord->cancelled_by  = Auth::user()->name;
            $cancelRecord->save();

            // ---------------------------------------------------------
            // UPDATE ORIGINAL BOOKING STATUS
            // ---------------------------------------------------------
            $booking->stock_status = 4; // Cancelled
            $booking->remarks = $booking->remarks . " | Cancelled: " . $request->cancel_reason;
            $booking->updated_by = Auth::user()->name;
            $booking->save();

            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Booking Cancelled, Ledger Reversed, and Record Archived successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => 'Error: ' . $e->getMessage()]);
        }
    }
    public function viewCancelledBookings(Request $request)
{
    if ($request->ajax()) {
        // Use the exact table name 'cancelled_booking_models'
        $query = DB::table('cancelled_booking_models')
            ->select(
                'cancelled_booking_models.*',
                'ledger.name as customer_name',
                'car_stock.reg_number',
                'car_stock.car_model'
            )
            ->leftJoin('ledger', 'ledger.id', '=', 'cancelled_booking_models.customer_id')
            ->leftJoin('car_stock', 'car_stock.id', '=', 'cancelled_booking_models.car_stock_id');

        // --- DATE FILTER ---
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('cancelled_booking_models.created_at', [
                $request->from_date . ' 00:00:00',
                $request->to_date . ' 23:59:59'
            ]);
        } else {
            // Default: Last 90 Days
            $query->where('cancelled_booking_models.created_at', '>=', now()->subDays(90));
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->filter(function ($instance) use ($request) {
                if ($request->has('search') && !empty($request->get('search')['value'])) {
                    $keyword = $request->get('search')['value'];
                    $instance->where(function ($q) use ($keyword) {
                        $q->where('cancelled_booking_models.booking_no', 'LIKE', "%$keyword%")
                            ->orWhere('ledger.name', 'LIKE', "%$keyword%")
                            ->orWhere('car_stock.reg_number', 'LIKE', "%$keyword%");
                    });
                }
            })
            ->editColumn('created_at', function ($row) {
                return date('d-M-Y H:i', strtotime($row->created_at));
            })
            ->editColumn('refund_amount', function ($row) {
                return number_format($row->refund_amount, 2);
            })
            ->addColumn('screenshot', function ($row) {
                if (!empty($row->payment_screenshot)) {
                    $url = asset($row->payment_screenshot);
                    return '<a href="' . $url . '" target="_blank" class="badge bg-info text-dark">View Proof</a>';
                }
                return '<span class="text-muted small">No File</span>';
            })
            ->rawColumns(['screenshot'])
            ->make(true);
    }

    return view('admin.booking.view-cancelled-booking');
}
}
