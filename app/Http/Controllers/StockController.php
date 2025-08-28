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

    public function storebooking(Request $req)
    {
        $req->validate([
            'reg_number' => 'required',
            'booking_person' => 'required',
            'customer' => 'required',
            'total_amount' => 'required',
            'adv_amount' => 'required',
            'dp' => 'required',
            'finance_amount' => 'required',
            'remarks' => 'required',
        ]);
        $today = date('dmY');
        $serviceJobNumber = BookingModel::where('booking_no', 'like', $today . '%')->pluck('booking_no');
        do {
            $book_no = $today . rand(111111, 999999);
        } while ($serviceJobNumber->contains($book_no));

        $car_no = DB::table('car_stock')
            ->where('id', $req->reg_number)
            ->select('reg_number')
            ->first();

        $carreg = $car_no->reg_number;

        $car_model_name = DB::table('car_stock')
            ->where('id', $req->reg_number)
            ->select('car_model')
            ->first();
        $carmodel = $car_model_name->car_model;

        $mytime = Carbon::now('Asia/Kolkata')->format('d-m-Y H:i:s');

        $customerdetails=DB::table('ledger')
                        ->where('id', $req->customer)
                        ->select('mobile_number','name')
                        ->first(); 


        $paymentMode = $req->paymentMode;

        $BookingModel = new BookingModel();

        $BookingModel->car_stock_id = $req->reg_number;
        $BookingModel->booking_no = $book_no;
        $BookingModel->customer_ledger_id = $req->customer;
        $BookingModel->booking_person = $req->booking_person;
        $BookingModel->total_amount = $req->total_amount;
        $BookingModel->adv_amount = $req->adv_amount;
        $BookingModel->due_amount = $req->dp;
        $BookingModel->finance_amount = $req->finance_amount;
        $BookingModel->remarks = $req->remarks;
        $BookingModel->created_by = Auth::user()->name;
        $BookingModel->save();
        $lastid = $BookingModel->id;

        if ($lastid) {
            $CustomerStatementModel = new CustomerStatementModel();
            $CustomerStatementModel->customer_id = $req->customer;
            $CustomerStatementModel->payment_type = 0;
            $CustomerStatementModel->amount = -$req->total_amount;
            $CustomerStatementModel->particular = 'Amount Debited for ' . '-' . $carreg . '-' . $carmodel . '-' . $mytime;
            $CustomerStatementModel->created_by = Auth::user()->name;
            $CustomerStatementModel->save();
            $lastid_1 = $BookingModel->id;

            if ($lastid_1) {
                $CustomerStatementModel = new CustomerStatementModel();
                $CustomerStatementModel->customer_id = $req->customer;
                $CustomerStatementModel->payment_type = 1;
                $CustomerStatementModel->amount = $req->adv_amount;
                $CustomerStatementModel->particular = 'Amount Credited for Booking Amount for' . '-' . $carreg . '-' . $carmodel . '-' . $paymentMode . '-' . $mytime;
                $CustomerStatementModel->created_by = Auth::user()->name;
                $CustomerStatementModel->save();
                $lastid_1 = $BookingModel->id;
            }
        }

        $Stockstatus = StockModel::find($req->reg_number);
        $Stockstatus->stock_status = 1;
        $Stockstatus->update();

        $sender = 'CAR4SL';
        $mob = $customerdetails->mobile_number;
        $name = $customerdetails->name;
        $auth = '3HqJI';
        $entid = '1701171869640632437';
        $temid = '1707172716926156370';
        $mob2 = [$mob];
        $mob3 = implode(',', $mob2);
        $msg1 = urlencode('प्रिय '. $name . ",\nCar4Sales को चुनने के लिए धन्यवाद! हम आपकी बुक की गई गाड़ी को जल्द से जल्द डिलीवर करने का प्रयास कर रहे हैं।\nकृपया वित्तीय प्रक्रिया को पूरा करने के लिए अपने आवश्यक दस्तावेज़ शीघ्र उपलब्ध कराएं। \nधन्यवाद,\nसादर,\nCar4Sales, \nमुजफ्फरपुर, मोतिहारी, दरभंगा  \nफोन: 7779995656");

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

        return back()->with('success', ' Booking  Added Successfully: ' . $lastid);
    }

    public function viewbooking()
    {
        $data['carbooking'] = BookingModel::getRecord();

        return view('admin.booking.view-booking', $data);
    }
    public function trafficchallan()
    {
        return view('admin.traffic-challan');
    }

    public function bookinpdf($id)
    {
        $data['carbooking'] = BookingModel::getRecordpdf($id);

        $regnumber = $data['carbooking'][0]['regnumber'];

        $pdf = Pdf::loadView('admin.booking.bookinPdf', $data);
        return $pdf->download($regnumber . '.pdf');
    }

    public function adddelivary(Request $req, $id)
    {
        $data['carbooking'] = BookingModel::getRecordpdf($id);

        $regnumber = $data['carbooking'][0]['regnumber'];
        $data['financer'] = DB::table('financer_details')->orderBy('financer_name','asc')->get();

        return view('admin.delivary.add-delivary', $data);
    }

    public function insertdelivary(Request $req)
    {
        $req->validate([
            'booking_id' => 'required|numeric',
            'booking_date' => 'required|date',
            'booking_person' => 'required',
            'name' => 'required',
            'father_name' => 'required',
            'mobile' => 'required|min_digits:10|max_digits:10',
            'aadhar' => 'required|min_digits:10|max_digits:12',
            'pan_card' => 'required|size:10',
            'city' => 'required',
            'address' => 'required',
            'reg_number' => 'required',
            'owner_sl_no' => 'required',
            'model_name' => 'required',
            'model_year' => 'required',
            'car_color' => 'required',
            'eng_number' => 'required',
            'chassis_number' => 'required',
            'sell_amount' => 'required',
            'booking_amount' => 'required',
            'finance_amount' => 'required',
            'dp' => 'required',
            'financer' => 'required',
            'remarks' => 'required',
            'electricle_work' => 'required',
            'ac_work_status' => 'required',
            'suspenstion_status' => 'required',
            'engine_status' => 'required',
            'starting_status' => 'required',
            'stepny_status' => 'required',
            'tools_kit_status' => 'required',
            'inspection_by' => 'required',
            'pdi_image' => 'required|image|mimes:jpg,png,jpeg,pdf|max:10240',
            'pdi_remarks' => 'required',
        ]);

        $mytime = Carbon::now('Asia/Kolkata')->format('d-m-Y H:i:s');

        $delivered_car = DB::table('car_delivary')
            ->where('reg_number', $req->reg_number)
            ->first();

            if($delivered_car)
            {
                return redirect('admin/view-booking')->with('error', 'Selected Car Already Delivered');
            }
            else
            {
                $user = DB::table('car_booking')
                        ->where('booking_no', $req->booking_id)
                        ->first();
        $customer_id = $user->customer_ledger_id;

        $CarDelivaryModel = new CarDelivaryModel();

        $CarDelivaryModel->booking_id = $req->booking_id;
        $CarDelivaryModel->booking_date = $req->booking_date;
        $CarDelivaryModel->booking_person = $req->booking_person;
        $CarDelivaryModel->name = $req->name;
        $CarDelivaryModel->father_name = $req->father_name;
        $CarDelivaryModel->mobile = $req->mobile;
        $CarDelivaryModel->aadhar = $req->aadhar;
        $CarDelivaryModel->pan_card = $req->pan_card;
        $CarDelivaryModel->city = $req->city;
        $CarDelivaryModel->address = $req->address;
        $CarDelivaryModel->reg_number = $req->reg_number;
        $CarDelivaryModel->owner_sl_no = $req->owner_sl_no;
        $CarDelivaryModel->model_name = $req->model_name;
        $CarDelivaryModel->model_year = $req->model_year;
        $CarDelivaryModel->car_color = $req->car_color;
        $CarDelivaryModel->eng_number = $req->eng_number;
        $CarDelivaryModel->chassis_number = $req->chassis_number;
        $CarDelivaryModel->sell_amount = $req->sell_amount;
        $CarDelivaryModel->booking_amount = $req->booking_amount;
        $CarDelivaryModel->finance_amount = $req->finance_amount;
        $CarDelivaryModel->dp = $req->dp;
        $CarDelivaryModel->paymentMode = $req->paymentMode;
        $CarDelivaryModel->financer = $req->financer;
        $CarDelivaryModel->remarks = $req->remarks;
        $CarDelivaryModel->electricle_work = $req->electricle_work;
        $CarDelivaryModel->ac_work_status = $req->ac_work_status;
        $CarDelivaryModel->suspenstion_status = $req->suspenstion_status;
        $CarDelivaryModel->engine_status = $req->engine_status;
        $CarDelivaryModel->starting_status = $req->starting_status;
        $CarDelivaryModel->stepny_status = $req->stepny_status;
        $CarDelivaryModel->tools_kit_status = $req->tools_kit_status;
        $CarDelivaryModel->inspection_by = $req->inspection_by;
        if ($req->hasFile('pdi_image'))
        {
            $d = new DateTime();
            $nd = $d->format("YmdHisv");
            $regnumber = $req->reg_number;
            $pdfext = $req->file('pdi_image')->getClientOriginalExtension();

            $uniqueFileName = uniqid() . '_' . time() . '_'. $regnumber . '.' . $pdfext;

            $file = $req->file('pdi_image');
            $file->move('upload/pdi', $uniqueFileName); 

            $CarDelivaryModel->pdi_image = $uniqueFileName;
        }

        $CarDelivaryModel->pdi_remarks = $req->pdi_remarks;

        $CarDelivaryModel->added_by = Auth::user()->name;
        $CarDelivaryModel->save();
        $lastid = $CarDelivaryModel->id;

        if ($lastid) {
            $CustomerStatementModel = new CustomerStatementModel();
            $CustomerStatementModel->customer_id = $customer_id;
            $CustomerStatementModel->payment_type = 1;
            $CustomerStatementModel->amount = $req->dp;
            $CustomerStatementModel->particular = 'Amount Credited for Down Payment for' . '-' . $req->reg_number . '-' . $req->model_name . '-' . $req->paymentMode . '-' . $mytime;
            $CustomerStatementModel->created_by = Auth::user()->name;
            $CustomerStatementModel->save();
            $lastid_1 = $CustomerStatementModel->id;
        }

        if ($lastid_1) {
            DB::table('car_booking')
                ->where('booking_no', $req->booking_id)
                ->update(['stock_status' => 3]);

            DB::table('car_stock')
                ->where('reg_number', $req->reg_number)
                ->update(['stock_status' => 3]);
        }

        return redirect('admin/view-booking')->with('success', 'Delivary Added Succesfully ' . $lastid);
        }
    }
}
