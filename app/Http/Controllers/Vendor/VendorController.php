<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\vendor\VendorModel as Vendor;

class VendorController extends Controller
{
    public function index()
    {   $vendors = Vendor::orderBy('id', 'desc')->get();
        return view('admin.Purchase.vendor',compact('vendors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'mobile' => 'required|unique:vendors,mobile',
            'father_name' => 'required',
            'aadhar_number' => 'required|unique:vendors,aadhar_number',
            'address' => 'required',
            'city' => 'required',
            'pincode' => 'required',
            'state' => 'required'
        ]);

        Vendor::create([
            'name' => $request->name,
            'mobile' => $request->mobile,
            'father_name' => $request->father_name,
            'aadhar_number' => $request->aadhar_number,
            'address' => $request->address,
            'city' => $request->city,
            'pincode' => $request->pincode,
            'state' => $request->state
        ]);

        return redirect()->back()->with('success', 'Vendor added successfully.');
    }
}
