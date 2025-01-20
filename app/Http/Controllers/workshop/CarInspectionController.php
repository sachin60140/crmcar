<?php

namespace App\Http\Controllers\workshop;

use App\Http\Controllers\Controller;
use App\Models\workshop\InspectionModel;
use Illuminate\Http\Request;

class CarInspectionController extends Controller
{
    public function index()
    {
        return view('admin.workshop.inspection');
    }

    public function storeinspection(Request $req)
    {
        $req->validate([
            'reg_number' => 'required',
            'purchase_date' => 'required|date',
            'vendor_name' => 'required',
            'vendor_mobile' => 'required|numeric',
            'pur_ins_image.*' => 'required|mimes:jpg,png,jpeg,pdf|max:10240',
            'remarks' => 'required',
        ]);

        if ($req->hasFile('pur_ins_image'))
            {
                $count = 0;
                foreach ($req->file('pur_ins_image') as $file)
                    {
                        $uniqueFileName = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
                        $filename = $file->getClientOriginalName();
                        $filesize = $file->getSize();
                        
                        $file->move('upload/inspection', $uniqueFileName); 

                        $InspectionModel = new InspectionModel;

                        $InspectionModel->reg_number = $req->reg_number;
                        $InspectionModel->purchase_date = $req->purchase_date;
                        $InspectionModel->vendor_name = $req->vendor_name;
                        $InspectionModel->vendor_mobile = $req->vendor_mobile;
                        $InspectionModel->pur_ins_image = $uniqueFileName;
                        $InspectionModel->remarks =$req->remarks;
                        $InspectionModel->save();

                        $count++;
                    }
                    $lastid = $InspectionModel->id;

                return back()->with('success', $count.' File Uploaded Successfully');
            }

        //return $req->all();
    }

    public function viewinspection(Request $req)
    {
        $inspection = collect();
        $search = $req['reg_number'] ?? "";
        
        if($search != "")
        {
            $inspection = InspectionModel::where('reg_number', 'LIKE', "%$search%")->get();
        }
        
        return view('admin.workshop.view-inspection')->with(compact('inspection', 'search'));
        
    }
}
