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

    public function viewdelivary(Request $request)
    {
        
        // 1. Initialize the query
        $query = DB::table('car_delivary');

        // 2. Apply Date Filter if user selected dates
        if ($request->filled('start_date') && $request->filled('end_date')) {
            // This filters records between Start Date (00:00:00) and End Date (23:59:59)
            $query->whereDate('created_at', '>=', $request->start_date)
                ->whereDate('created_at', '<=', $request->end_date);
        }

        // 3. Fetch Data (ordered by latest first)
        $data['cardelivary'] = $query->orderBy('id', 'desc')->get();

        // 4. Return View
        return view('admin.delivary.view-delivary', $data);
    }

    public function delivarypdf($id)
    {
        

        $data['getRecords'] = CarDelivaryModel::getpdfRecord($id);

        $regnumber= $data['getRecords'][0]['reg_number'];

        $pdf = Pdf::loadView('admin.delivary.delivary_pdf',$data);

        return $pdf->download($regnumber.'.pdf');
    }
}
