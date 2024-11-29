<?php

namespace App\Http\Controllers\dto;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DtoModel;
use DateTime;
use Auth;
use Illuminate\Support\Facades\DB;

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

            $file = $req->file('upload_pdf');
            $pdfext = $req->file('upload_pdf')->getClientOriginalExtension();
            $pdfFileName = $d->format("YmdHisv") . 'dto' . '.' . $pdfext;
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
        $data['dtofiledata'] = DB::table('dto_dispatch')->get();
        return view('admin.dto.view-file',$data);

    }
}
