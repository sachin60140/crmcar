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

    // public function viewdelivary(Request $request)
    // {
        
    //     // 1. Initialize the query
    //     $query = DB::table('car_delivary');

    //     // 2. Apply Date Filter if user selected dates
    //     if ($request->filled('start_date') && $request->filled('end_date')) {
    //         // This filters records between Start Date (00:00:00) and End Date (23:59:59)
    //         $query->whereDate('created_at', '>=', $request->start_date)
    //             ->whereDate('created_at', '<=', $request->end_date);
    //     }

    //     // 3. Fetch Data (ordered by latest first)
    //     $data['cardelivary'] = $query->orderBy('id', 'desc')->get();

    //     // 4. Return View
    //     return view('admin.delivary.view-delivary', $data);
    // }
    public function viewdelivary(Request $request)
    {
        $query = DB::table('car_delivary');

        // 1. Check if user filtered dates, otherwise use Default (Last 6 Months)
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $start_date = $request->start_date;
            $end_date   = $request->end_date;
        } else {
            // Default: From 6 months ago to Today
            $start_date = date('Y-m-d', strtotime('-6 months'));
            $end_date   = date('Y-m-d');
        }

        // 2. Apply the Filter
        $query->whereDate('created_at', '>=', $start_date)
            ->whereDate('created_at', '<=', $end_date);

        // 3. Fetch Data
        $data['cardelivary'] = $query->orderBy('id', 'desc')->get();

        // 4. Pass the dates back to the view so they appear in the input boxes
        $data['start_date'] = $start_date;
        $data['end_date']   = $end_date;

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
