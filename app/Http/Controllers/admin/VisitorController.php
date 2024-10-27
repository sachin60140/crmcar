<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class VisitorController extends Controller
{
    public function vistordata()
    {
       $data['visitordata'] = DB::table('visitor')->get();
        return view('admin.visitor.view-visitor-data',$data); 
    }

    public function leadallotment()
    {
        $data['telecaller'] = DB::table('users')
                            ->where('user_type','2')
                            ->select('id','name')
                            ->get();
        return view('admin.Data.lead-allotment',$data);
    }

    public function storeleadallotment(Request $request)
    {
        
        $request->validate([
                
            'telecaller' => 'required',
            'lead_qty' => 'required|numeric|min_digits:1|max_digits:3',
        ]);
        $lead_count = $request->lead_qty;
        $emp_name = $request->telecaller;

        $collection = DB::table('customer_lead')
                            ->whereNull('lead_asign')
                            ->inRandomOrder()->limit($lead_count)->get();;
         
        $count_number = 0;
        foreach ($collection as $key => $value) {
            
            DB::table('customer_lead')
            ->where('id', $value->id)
            ->update(['lead_asign' => $emp_name,'lead_status'=>"6"]);
            $count_number++;
        }

        return redirect()->back()->with("success","Total ". $count_number ." Lead Alloted");

    }

    public function randomrecords()
    {
        $lead_count = '3';
        $collection = DB::table('customer_lead')
                            ->whereNull('lead_asign')
                            ->inRandomOrder()->limit($lead_count)->get();;
         
        $count_number = 0;
        foreach ($collection as $key => $value) {
            /* echo $value->id, "<br>"; */
            DB::table('customer_lead')
            ->where('id', $value->id)
            ->update(['lead_asign' => "Employee",'lead_status'=>"6"]);

            $count_number++;
        }

        echo 'total recors updated '.$count_number;
    }

}
