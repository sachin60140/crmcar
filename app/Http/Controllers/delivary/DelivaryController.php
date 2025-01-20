<?php

namespace App\Http\Controllers\delivary;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CarDelivaryModel;
use Barryvdh\DomPDF\Facade\Pdf;

class DelivaryController extends Controller
{
    function adddelivary12($id)
    {
        $data['car_stock'] = DB::table('car_stock')
                ->orderBy('reg_number','asc')
                ->where('stock_status','=','1')
                ->get();

        $data['ledger'] = DB::table('ledger')
                ->orderBy('id','desc')
                ->get();

        

        return view('admin.delivary.add-delivary',$data);
    }


    function test()
    {
        return view('admin.delivary.test');
    }

    public function viewdelivary()
    {
        
        $data['cardelivary'] = DB::table('car_delivary')->get();
        

            
        return view('admin.delivary.view-delivary',$data);
    }

    public function delivarypdf($id)
    {
        

        $data['getRecords'] = CarDelivaryModel::getpdfRecord($id);

        $regnumber= $data['getRecords'][0]['reg_number'];

        $pdf = Pdf::loadView('admin.delivary.delivary_pdf',$data);

        return $pdf->download($regnumber.'.pdf');
    }
}
