<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\StockModel;
use Auth;

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

        return view('admin.add-booking', $data); 
    }


    public function trafficchallan()
    {
        return view('admin.traffic-challan');
    }
}
