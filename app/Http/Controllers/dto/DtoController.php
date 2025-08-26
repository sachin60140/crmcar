<?php

namespace App\Http\Controllers\dto;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DtoModel;
use DateTime;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class DtoController extends Controller
{
    public function index()
    {
        return view("admin.dto.add-file");
    }

    public function adddtofile(Request $req)
    {
        $req->validate([
            
            'reg_number' => 'required',
            'rto_location' => 'required',
            'status' => 'required',
            'remarks' => 'required|min:3',
            'upload_pdf' => 'required|mimes:pdf|max:20000',
        ]);

        $DtoModel = new DtoModel;

        $DtoModel->reg_number = $req->reg_number;
        $DtoModel->rto_location = $req->rto_location;
        $DtoModel->vendor_name = $req->vendor_name;
        $DtoModel->vendor_mobile_number = $req->vendor_mobile_number;
        $DtoModel->dispatch_date = $req->dispatch_date;
        $DtoModel->status = $req->status;
        if ($req->hasFile('upload_pdf'))
        {
            $d = new DateTime();
            $nd = $d->format("YmdHisv");
            $reg_number = Str::upper($req->reg_number);
            $file = $req->file('upload_pdf');
            $pdfext = $req->file('upload_pdf')->getClientOriginalExtension();
            $pdfFileName = $reg_number.'_'.$d->format("YmdHisv") . 'dto' . '.' . $pdfext;
            $file->move('files/', $pdfFileName);
            $DtoModel->upload_pdf = $pdfFileName;
        }
        $DtoModel->remarks = $req->remarks;
        $DtoModel->created_by = Auth::user()->name;
        $DtoModel->save();
        $lastid = $DtoModel->id;
        return back()->with('success', ' Dto File added Successfully: ' .$lastid);
    }

    public function viewdtofile()
    {
        $data['dtofiledata'] = DB::table('dto_dispatch')
                                ->whereIn('status',['Ready to Dispatch','Dispatched','Hold'])->orderBy('dispatch_date', 'DESC')->get();
        return view('admin.dto.view-file',$data);

    }

    function viewonlinedtofile()
    {
        $data['dtofiledata'] = DB::table('dto_dispatch')
                                ->where('status','Online')->orderBy('online_date', 'DESC')->get();

        return view('admin.dto.view-online-file',$data);
    }

    public function editdtofile($id)
    {
         $data['getRecord'] = DB::table('dto_dispatch')->where('id', '=', $id)->first();
        
        return view('admin.dto.edit-file', $data);
    }

    public function updatedtofile(Request $req, $id)
    {
        $req->validate([
           
            'vendor_name' => 'required',
            'vendor_mobile_number' => 'required|min_digits:5|max_digits:10',
            'dispatch_date' => 'required',
            'status' => 'required',
            'upload_mparivahan' => 'nullable|mimes:png,jpg,jpeg,pdf',
            'remarks' => 'required',
        ]);

        $mytime = Carbon::now('Asia/Kolkata')->format('Y-m-d H:i:s');

        $DtoModel = DtoModel::find($id);

        $DtoModel->vendor_name = $req->vendor_name;
        $DtoModel->vendor_mobile_number = $req->vendor_mobile_number;
        $DtoModel->dispatch_date = $req->dispatch_date;
        $DtoModel->status = $req->status;

        if ($req->hasFile('upload_mparivahan'))
        {
            $d = new DateTime();
            $nd = $d->format("YmdHisv");

            $file = $req->file('upload_mparivahan');
            $pdfext = $req->file('upload_mparivahan')->getClientOriginalExtension();
            $pdfFileName = $d->format("YmdHisv") . 'mpari' . '.' . $pdfext;
            $file->move('files/', $pdfFileName);
            $DtoModel->upload_mparivahan = $pdfFileName;
        }

        $DtoModel->online_date = $req->online_date;

        $DtoModel->remarks = $req->remarks;

        $DtoModel->updated_by = Auth::user()->name;

        $DtoModel->updated_at = $mytime;

        $DtoModel->update();

        //return back()->with('success', 'DTO File  Updated Succesfully');

        return redirect('admin/dto/view-dto-file')->with('success', 'DTO File  Updated Succesfully');
    }
}
