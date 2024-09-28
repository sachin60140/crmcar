<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\FinanceFileModel;
use Carbon\Carbon;
use App\Models\UpdateRemarksFinanceFileModel;
use Illuminate\Support\Facades\Auth;

class FinanceController extends Controller
{
    public function addfinancefile()
    {
        $data['financer_list'] = DB::table('financer_details')->orderBy('financer_name', 'asc')->get();

        return view('admin.finance.add-finance', $data);
    }

    public function storefinancefiledetails(Request $req)
    {
        $req->validate([
            'cutomer_name' => 'required',
            'mobile' => 'required|min_digits:10|max_digits:10',
            'cutomer_pan' => 'required|min:10|max:10',
            'aadhar' => 'required|min_digits:12|max_digits:12',
            'address' => 'required',
            'reg_number' => 'required',
            'rto_name' => 'required',
            'financer_details_id' => 'required',
            'booking_amount' => 'required',
            'finance_amount' => 'required',
            'finance_remarks' => 'required',
        ]);

        $finance_name = DB::table('financer_details')->where('id','=' ,$req->financer_details_id)->first();
        $file_status = 'File Submited to Financer';

        $remarks = $finance_name->financer_name . '-' . $file_status;

        $FinanceFileModel = new FinanceFileModel();

        $FinanceFileModel->cutomer_name = $req->cutomer_name;
        $FinanceFileModel->mobile = $req->mobile;
        $FinanceFileModel->cutomer_pan = $req->cutomer_pan;
        $FinanceFileModel->aadhar = $req->aadhar;
        $FinanceFileModel->address = $req->address;
        $FinanceFileModel->reg_number = $req->reg_number;
        $FinanceFileModel->rto_name = $req->rto_name;
        $FinanceFileModel->financer_details_id = $req->financer_details_id;
        $FinanceFileModel->booking_amount = $req->booking_amount;
        $FinanceFileModel->finance_amount = $req->finance_amount;
        $FinanceFileModel->finance_remarks = $req->finance_remarks;
        $FinanceFileModel->created_by = Auth::user()->name;
        $FinanceFileModel->save();

        $lastid = $FinanceFileModel->id;

        if($lastid)
        {
            $UpdateRemarksFinanceFileModel = new UpdateRemarksFinanceFileModel();

            $UpdateRemarksFinanceFileModel->finace_file_id = $lastid;
            $UpdateRemarksFinanceFileModel->remarks = $remarks . '-' . $req->finance_remarks;
            $UpdateRemarksFinanceFileModel->created_by = Auth::user()->name;

            $UpdateRemarksFinanceFileModel->save();
            $lastid = $UpdateRemarksFinanceFileModel->id;

        }

        return back()->with('success', ' Finance File Added Successfully: ' . $lastid);
    }

    public function viewfinancefile()
    {
        $data['viewfinancefiledetails'] = FinanceFileModel::getrecord();

        return view('admin.finance.view-finance-file', $data);
    }

    public function updatefinancefile($id)
    {
        $data['updatefinancefiledetails'] = FinanceFileModel::getrecorddetails($id);

        $data['financer_details'] = DB::table('financer_details')->get();

        $data['file_status'] = DB::table('finance_file_status')->get();

        return view('admin.finance.update-finance-file', $data);
    }

    public function updatefilestatus(Request $req)
    {
        $req->validate([
            'cutomer_name' => 'required',
            'mobile' => 'required|min_digits:10|max_digits:10',
            'cutomer_pan' => 'required|min:10|max:10',
            'aadhar' => 'required|min_digits:12|max_digits:12',
            'address' => 'required',
            'reg_number' => 'required',
            'rto_name' => 'required',
            'financer_details_id' => 'required',
            'finance_amount' => 'required',
            'finance_remarks_update' => 'required',
        ]);

        $mytime = Carbon::now('Asia/Kolkata')->format('Y-m-d H:i:s');

        $customer_id = $req->cutomer_id;
        $finance_name = DB::table('financer_details')->where('id','=' ,$req->financer_details_id)->first();
        $file_status = DB::table('finance_file_status')->where('id','=' ,$req->file_status)->first();
       

        $FinanceFileModel = FinanceFileModel::find($customer_id);

        $FinanceFileModel->cutomer_name = $req->cutomer_name;
        $FinanceFileModel->mobile = $req->mobile;
        $FinanceFileModel->cutomer_pan = $req->cutomer_pan;
        $FinanceFileModel->aadhar = $req->aadhar;
        $FinanceFileModel->address = $req->address;
        $FinanceFileModel->rto_name = $req->rto_name;
        $FinanceFileModel->financer_details_id = $req->financer_details_id;
        $FinanceFileModel->file_status = $req->file_status;

        $FinanceFileModel->finance_amount = $req->finance_amount;
        $FinanceFileModel->updated_at = $mytime;

        $result = $FinanceFileModel->update();

        $remarks = $finance_name->financer_name . '-' . $file_status->file_status_type;

        if ($result) {
            $UpdateRemarksFinanceFileModel = new UpdateRemarksFinanceFileModel();

            $UpdateRemarksFinanceFileModel->finace_file_id = $req->cutomer_id;
            $UpdateRemarksFinanceFileModel->remarks = $remarks.'-'.$req->finance_remarks_update;
            $UpdateRemarksFinanceFileModel->created_by = Auth::user()->name;

            $UpdateRemarksFinanceFileModel->save();
            $lastid = $UpdateRemarksFinanceFileModel->id;
        }
        return redirect('admin/view-finance-file')->with('success', ' Remarks Added Successfully: ' . $lastid);
    }

    public function viewrfinancefileremarks($id)
    {
       
         $data['customer_details'] = DB::table('finace_file')
                                    ->join('financer_details', 'financer_details_id', '=', 'financer_details.id')
                                    ->join('finance_file_status', 'file_status', '=', 'finance_file_status.id')
                                    ->where('finace_file.id','=', $id)
                                    ->get();

         $data['remarks'] = DB::table('finance_remarks')->where('finace_file_id','=', $id)->orderBy('id', 'desc')->get();
        
        return view('admin.finance.view-finance-file-status',$data);
    }
}
