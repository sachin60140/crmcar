<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UploadStockPaperController extends Controller
{
    public function addstockpaper()
    {
        $data['car_stock']= DB::table('car_stock')->orderBy('reg_number', 'asc')->get();
        $data['upload_paper'] = DB::table('car_stock_doc')->get();
        return view('admin.stock.add-stock-paper',$data);
    }
}
