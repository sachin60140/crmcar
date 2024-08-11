<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\StockModel;
use App\Models\BookingModel;
use App\Models\CustomerStatementModel;
use Auth;
use Carbon\Carbon;

class StockController extends Controller
{
    public function addstock()
    {
        $data = DB::table('branch')
                ->orderBy('branch_name','asc')
                ->get();

        return view('admin.add-stock', compact('data'));
    }
    public function insertstock(Request $req)
    {
        $req->validate([
                
            'branch' => 'required',
            'car_model' => 'required',
            'reg_number' => 'required',
            'car_model_year' => 'required|numeric',
            'color' => 'required',
            'fuel_type' => 'required',
            'owner_sl_no' => 'required|numeric',
            'price' => 'required',
            'lastprice' => 'required',
        ]);

        $StockModel = new StockModel;

        $StockModel->branch = $req->branch;
        $StockModel->car_model = $req->car_model;
        $StockModel->reg_number = $req->reg_number;
        $StockModel->car_model_year = $req->car_model_year;
        $StockModel->color = $req->color;
        $StockModel->fuel_type = $req->fuel_type;
        $StockModel->owner_sl_no = $req->owner_sl_no;
        $StockModel->price = $req->price;
        $StockModel->lastprice = $req->lastprice;
        $StockModel->added_by = Auth::user()->name;
        $StockModel->save();
        $lastid = $StockModel->id;

    return back()->with('success', ' Stock Added Successfully: ' .$lastid);
        
    }

    public function viewstock()
    {
       $data['getRecord'] = StockModel::getRecord();

       return view('admin.view-stock',$data);
    }

    public function booking()
    {
        $data['car_stock'] = DB::table('car_stock')
                ->orderBy('reg_number','asc')
                ->get();

                $data['ledger'] = DB::table('ledger')
                ->orderBy('id','desc')
                ->get();

        return view('admin.add-booking', $data); 
    }

    public function storebooking(Request $req)
    {
        $req->validate([
                
            'reg_number' => 'required',
            'customer' => 'required',
            'delivary_date' => 'required',
            'total_amount' => 'required',
            'adv_amount' => 'required',
            'due_amount' => 'required',
            'remarks' => 'required',
        ]);

        $car_no =  DB::table('car_stock')->where('id', $req->reg_number)
                    ->select('reg_number')            
                    ->first();

        $carreg = $car_no->reg_number;
        
        $car_model_name = DB::table('car_stock')->where('id', $req->reg_number)->select('car_model')->first();
        $carmodel=$car_model_name->car_model;

        $mytime = Carbon::now('Asia/Kolkata')->format('d-m-Y H:i:s');

        $paymentMode = $req->paymentMode;

        $BookingModel = new BookingModel;

        $BookingModel->car_stock_id = $req->reg_number;
        $BookingModel->customer_ledger_id = $req->customer;
        $BookingModel->delivary_date = $req->delivary_date;
        $BookingModel->total_amount = $req->total_amount;
        $BookingModel->adv_amount = $req->adv_amount;
        $BookingModel->due_amount = $req->due_amount;
        $BookingModel->remarks = $req->remarks;
        $BookingModel->created_by = Auth::user()->name;
        $BookingModel->save();
        $lastid = $BookingModel->id;

        if($lastid)
        {
            $CustomerStatementModel = new CustomerStatementModel;
            $CustomerStatementModel->customer_id = $req->customer;
            $CustomerStatementModel->payment_type = 0;
            $CustomerStatementModel->amount = -$req->total_amount;
            $CustomerStatementModel->particular = 'Amount Debited for ' . '-' . $carreg . '-' . $carmodel .'-' . $mytime;
            $CustomerStatementModel->created_by = Auth::user()->name;
            $CustomerStatementModel->save();
            $lastid_1 = $BookingModel->id;

            if($lastid_1)
            {
                $CustomerStatementModel = new CustomerStatementModel;
                $CustomerStatementModel->customer_id = $req->customer;
                $CustomerStatementModel->payment_type = 1;
                $CustomerStatementModel->amount = $req->adv_amount;
                $CustomerStatementModel->particular = 'Amount Credited for Booking Amount for' . '-' . $carreg . '-' . $carmodel .'-' . $paymentMode .'-' . $mytime;
                $CustomerStatementModel->created_by = Auth::user()->name;
                $CustomerStatementModel->save();
                $lastid_1 = $BookingModel->id;
            }
        }

        return back()->with('success', ' Booking  Added Successfully: ' .$lastid);
    }

    public function viewbooking()
        {
            
            $data['carbooking'] = BookingModel::getRecord();
            
            return view('admin.booking.view-booking',$data);
        }



    public function trafficchallan()
    {
        
        return view('admin.traffic-challan');
    }

}
