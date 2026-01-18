<?php

namespace App\Http\Controllers\dto;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DtoModel;
use DateTime;
use Carbon\Carbon;
use App\Models\DtoFileHistoryModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Services\SmsService;

class DtoController extends Controller
{
    protected $smsService;

    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
    }

    public function index()
    {
        // Fetch all records from the 'financer_details' table
        // Adjust 'name' if you want to sort by a specific column
        $financers = DB::table('financer_details')->orderBy('id', 'asc')->get();

        // Pass the variable 'financers' to the view
        return view("admin.dto.add-file", compact('financers'));
    }

    // public function adddtofile(Request $req)
    // { 

    //     $req->validate([

    //         'reg_number' => 'required',
    //         'rto_location' => 'required',
    //         'Purchaser_mobile_number' => 'required|numeric|digits_between:9,12',
    //         'vendor_name' => 'required',
    //         'status' => 'required',
    //         'remarks' => 'required|min:3',
    //         'upload_pdf' => 'required|mimes:pdf|max:20000',
    //     ]);

    //     $DtoModel = new DtoModel;

    //     $DtoModel->reg_number = $req->reg_number;
    //     $DtoModel->rto_location = $req->rto_location;
    //     $DtoModel->purchaser_name = $req->purchaser_name;
    //     $DtoModel->Purchaser_mobile_number = $req->Purchaser_mobile_number;
    //     $DtoModel->vendor_name = $req->vendor_name;
    //     $DtoModel->vendor_mobile_number = $req->vendor_mobile_number;
    //     $DtoModel->dispatch_date = $req->dispatch_date;
    //     $DtoModel->status = $req->status;
    //     if ($req->hasFile('upload_pdf'))
    //     {
    //         $d = new DateTime();
    //         $nd = $d->format("YmdHisv");
    //         $reg_number = Str::upper($req->reg_number);
    //         $file = $req->file('upload_pdf');
    //         $pdfext = $req->file('upload_pdf')->getClientOriginalExtension();
    //         $pdfFileName = $reg_number.'_'.$d->format("YmdHisv") . 'dto' . '.' . $pdfext;
    //         $file->move('files/', $pdfFileName);
    //         $DtoModel->upload_pdf = $pdfFileName;
    //     }
    //     $DtoModel->remarks = $req->remarks;
    //     $DtoModel->created_by = Auth::user()->name;
    //     $DtoModel->save();
    //     $lastid = $DtoModel->id;
    //     return back()->with('success', ' Dto File added Successfully: ' .$lastid);
    // }

    // public function adddtofile(Request $req)
    // {
    //     // 1. Validation (Same as before)
    //     $req->validate([
    //         'reg_number'              => 'required|string|max:50',
    //         'rto_location'            => 'required',
    //         'status'                  => 'required',
    //         'dispatch_date'           => 'required_unless:status,Ready to Dispatch|nullable|date',
    //         'remarks'                 => 'required|min:3',
    //         'upload_pdf'              => 'required|mimes:pdf|max:10240',
    //     ]);

    //     // Use Database Transaction to ensure both Main Entry and History are saved, or neither.
    //     DB::beginTransaction();

    //     try {
    //         // 2. Save Main Model
    //         $dto = new DtoModel;
    //         $dto->reg_number              = Str::upper($req->reg_number);
    //         $dto->rto_location            = $req->rto_location;
    //         $dto->purchaser_name          = $req->purchaser_name;
    //         $dto->Purchaser_mobile_number = $req->Purchaser_mobile_number;
    //         $dto->vendor_name             = $req->vendor_name;
    //         $dto->vendor_mobile_number    = $req->vendor_mobile_number;
    //         $dto->status                  = $req->status;
    //         $dto->dispatch_date           = ($req->status === 'Ready to Dispatch') ? null : $req->dispatch_date;
    //         $dto->remarks                 = $req->remarks; // Current remarks
    //         $dto->created_by              = Auth::user()->name;

    //         if ($req->hasFile('upload_pdf')) {
    //             $file = $req->file('upload_pdf');
    //             $fileName = Str::upper($req->reg_number) . '_' . now()->format('YmdHis') . '_dto.' . $file->getClientOriginalExtension();
    //             $file->move(public_path('files'), $fileName);
    //             $dto->upload_pdf = $fileName;
    //         }

    //         $dto->save();

    //         // 3. Save History Tracking
    //         $history = new DtoFileHistoryModel;
    //         $history->dto_file_id = $dto->id;
    //         $history->status      = $req->status;
    //         $history->remarks     = $req->remarks;
    //         $history->created_by  = Auth::user()->name;
    //         $history->save();

    //         DB::commit(); // Save everything

    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'File Added & History Logged. ID: ' . $dto->id
    //         ]);
    //     } catch (\Exception $e) {
    //         DB::rollBack(); // Undo if error
    //         return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
    //     }
    // }

    public function adddtofile(Request $req)
    {
        // 1. Validation
        $req->validate([
            'reg_number'                => 'required|string|max:50',
            'rto_location'              => 'required|string',
            'status'                    => 'required|string',
            // Removed spaces after commas in required_unless
            'dispatch_date'             => 'required_unless:status,Ready to Dispatch,Hold|nullable|date|before_or_equal:today',
            'remarks'                   => 'required|string|min:3',
            'upload_pdf'                => 'required|mimes:pdf|max:10240',
            'financer'                  => 'nullable|string|max:255',
            'challan_date'              => 'nullable|date|before_or_equal:today',
            'Purchaser_mobile_number'   => 'required|digits:10|regex:/^[6-9]\d{9}$/',
            'purchaser_name'            => 'required|string|max:150',
        ]);

        // Use Database Transaction to ensure both Main Entry and History are saved, or neither.
        DB::beginTransaction();

        try {
            // 2. Save Main Model
            $dto = new DtoModel;
            $dto->reg_number              = Str::upper($req->reg_number);
            $dto->rto_location            = $req->rto_location;
            $dto->purchaser_name          = $req->purchaser_name;
            $dto->Purchaser_mobile_number = $req->Purchaser_mobile_number;
            $dto->vendor_name             = $req->vendor_name;
            $dto->vendor_mobile_number    = $req->vendor_mobile_number;

            // --- NEW INPUTS ADDED HERE ---
            $dto->financer                = $req->financer;
            $dto->challan_date            = $req->challan_date;
            // -----------------------------

            $dto->status                  = $req->status;
            $dto->dispatch_date           = ($req->status === 'Ready to Dispatch') ? null : $req->dispatch_date;
            $dto->remarks                 = $req->remarks;
            $dto->created_by              = Auth::user()->name;

            if ($req->hasFile('upload_pdf')) {
                $file = $req->file('upload_pdf');
                $fileName = Str::upper($req->reg_number) . '_' . now()->format('YmdHis') . '_dto.' . $file->getClientOriginalExtension();
                $file->move(public_path('files'), $fileName);
                $dto->upload_pdf = $fileName;
            }

            $dto->save();

            // 3. Save History Tracking
            $history = new DtoFileHistoryModel;
            $history->dto_file_id = $dto->id;
            $history->status      = $req->status;
            $history->remarks     = $req->remarks;
            $history->created_by  = Auth::user()->name;
            $history->save();

            DB::commit(); // Save everything

            return response()->json([
                'status' => 'success',
                'message' => 'File Added & History Logged. ID: ' . $dto->id
            ]);
        } catch (\Exception $e) {
            DB::rollBack(); // Undo if error
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
    // public function getHistory($id)
    // {
    //     // Fetch history, newest first
    //     $history = DtoFileHistoryModel::where('dto_file_id', $id)
    //                 ->orderBy('created_at', 'desc')
    //                 ->get();

    //     // Format the date for easy reading
    //     $history->transform(function ($item) {
    //         $item->formatted_date = date('d-M-Y h:i A', strtotime($item->created_at));
    //         return $item;
    //     });

    //     return response()->json($history);
    // }

    public function getHistory($id)
    {
        // Fetch history, sorted by latest first
        $history = DtoFileHistoryModel::where('dto_file_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Transform the data to include formatted date and file URL
        $history->transform(function ($item) {
            $item->formatted_date = date('d-M-Y h:i A', strtotime($item->created_at));

            // CHECK: If history has a file_name, generate the full URL
            if (!empty($item->file_name)) {
                $item->file_url = asset('files/' . $item->file_name);
            } else {
                $item->file_url = null;
            }

            return $item;
        });

        return response()->json($history);
    }


    //-----------
    public function viewdtofile()
    {
       $data['dtofiledata'] = DB::table('dto_dispatch')
        ->whereIn('status', ['Ready to Dispatch', 'Dispatched', 'Work Not Started', 'Hold'])
        ->whereNull('deleted_at') // <--- ADD THIS LINE to hide deleted records
        ->orderBy('dispatch_date', 'DESC')
        ->get();

        return view('admin.dto.view-file', $data);
    }
    

    function viewonlinedtofile()
    {
        $data['dtofiledata'] = DB::table('dto_dispatch')
            ->where('status', 'Online')->orderBy('online_date', 'DESC')->get();

        return view('admin.dto.view-online-file', $data);
    }

    public function editdtofile($id)
    {
        $record = DB::table('dto_dispatch')->where('id', $id)->first();

        if (!$record) {
            return redirect()->back()->with('error', 'Record not found.');
        }

        // Extract first 4 characters (e.g., BR01)
        $reg_prefix = substr($record->reg_number, 0, 4);

        // Look up location from dto_code table
        $results = DB::table('dto_code')->where('code', 'LIKE', $reg_prefix . '%')->first();

        // Fallback logic
        $reglocation = $results ? $results->location : $record->rto_location;

        $financers = DB::table('financer_details')->orderBy('financer_name', 'asc')->get();

        // Pass everything to the view
        return view('admin.dto.edit-file', [
            'getRecord' => $record,
            'reglocation' => $reglocation,
            'financers' => $financers
        ]);
    }

    // public function updatedtofile(Request $req, $id)
    // {
    //     $req->validate([
    //         'Purchaser_mobile_number' => 'required|numeric|digits_between:9,12',
    //         'vendor_name' => 'required',
    //         'vendor_name' => 'required',
    //         'vendor_mobile_number' => 'required|min_digits:5|max_digits:10',
    //         'dispatch_date' => 'required',
    //         'status' => 'required',
    //         'upload_mparivahan' => 'nullable|mimes:png,jpg,jpeg,pdf',
    //         'remarks' => 'required',
    //     ]);

    //     $mytime = Carbon::now('Asia/Kolkata')->format('Y-m-d H:i:s');

    //     $DtoModel = DtoModel::find($id);
    //     $DtoModel->purchaser_name = $req->purchaser_name;
    //     $DtoModel->Purchaser_mobile_number = $req->Purchaser_mobile_number;
    //     $DtoModel->vendor_name = $req->vendor_name;
    //     $DtoModel->vendor_mobile_number = $req->vendor_mobile_number;
    //     $DtoModel->dispatch_date = $req->dispatch_date;
    //     $DtoModel->status = $req->status;

    //     if ($req->hasFile('upload_mparivahan')) {
    //         $d = new DateTime();
    //         $nd = $d->format("YmdHisv");

    //         $file = $req->file('upload_mparivahan');
    //         $pdfext = $req->file('upload_mparivahan')->getClientOriginalExtension();
    //         $pdfFileName = $d->format("YmdHisv") . 'mpari' . '.' . $pdfext;
    //         $file->move('files/', $pdfFileName);
    //         $DtoModel->upload_mparivahan = $pdfFileName;
    //     }

    //     $DtoModel->online_date = $req->online_date;

    //     $DtoModel->remarks = $req->remarks;

    //     $DtoModel->updated_by = Auth::user()->name;

    //     $DtoModel->updated_at = $mytime;

    //     $DtoModel->update();

    //     //return back()->with('success', 'DTO File  Updated Succesfully');

    //     if ($req->status == 'Online') {
    //         $this->smsService->sendCarTransferNotification(
    //             $DtoModel->purchaser_name,
    //             $DtoModel->Purchaser_mobile_number,
    //             $DtoModel->reg_number, // Assuming you have this field
    //             $DtoModel->online_date
    //         );
    //     }

    //     return redirect('admin/dto/view-dto-file')->with('success', 'DTO File  Updated Succesfully');
    // }

    // public function updatedtofile(Request $req, $id)
    // {
    //     // 1. Validation
    //     $req->validate([
    //         'Purchaser_mobile_number' => 'required|digits:10|regex:/^[6-9]\d{9}$/',
    //         'vendor_name'             => 'required|string|max:150',
    //         'vendor_mobile_number'    => 'required|digits:10|regex:/^[6-9]\d{9}$/', // Fixed
    //         'rto_location'            => 'required|string', 
    //         'dispatch_date'           => 'required_unless:status,Ready to Dispatch,Hold|nullable|date',
    //         'status'                  => 'required',
    //         'remarks'                 => 'required',
    //         'upload_mparivahan'       => 'nullable|mimes:png,jpg,jpeg,pdf|max:5120',
    //         'upload_pdf'              => 'nullable|mimes:pdf|max:10240',
    //         'purchaser_name'          => 'required|string|max:150',
    //         'financer'                => 'nullable|string',
    //         'challan_date'            => 'nullable|date',
    //     ]);
    //     $mytime = Carbon::now('Asia/Kolkata')->format('Y-m-d H:i:s');
    //     $DtoModel = DtoModel::findOrFail($id);

    //     // ======================================================
    //     // 2. HISTORY TRACKING (Archive Old State)
    //     // ======================================================
    //     $history = new DtoFileHistoryModel;
    //     $history->dto_file_id = $DtoModel->id;
    //     $history->status      = $DtoModel->status;       // OLD Status
    //     $history->remarks     = $DtoModel->remarks;      // OLD Remarks

    //     // Only save the filename to history if the user is uploading a NEW file.
    //     if ($req->hasFile('upload_pdf')) {
    //         $history->file_name = $DtoModel->upload_pdf; // Save the file being replaced
    //     } else {
    //         $history->file_name = null; // No file change
    //     }

    //     $history->created_by  = Auth::user()->name;
    //     $history->created_at  = $mytime;
    //     $history->updated_at  = $mytime;
    //     $history->save();
    //     // ======================================================

    //     // 3. Update Fields
    //     $DtoModel->rto_location            = $req->rto_location; // Now Editable
    //     $DtoModel->purchaser_name          = $req->purchaser_name;
    //     $DtoModel->Purchaser_mobile_number = $req->Purchaser_mobile_number;
    //     $DtoModel->vendor_name             = $req->vendor_name;
    //     $DtoModel->vendor_mobile_number    = $req->vendor_mobile_number;

    //     // --- NEW FIELDS ---
    //     $DtoModel->financer                = $req->financer;
    //     $DtoModel->challan_date            = $req->challan_date;
    //     // ------------------

    //     $DtoModel->status                  = $req->status;

    //     // Logic: If status is 'Ready' or 'Hold', clear the dispatch date, otherwise save it
    //     if ($req->status === 'Ready to Dispatch' || $req->status === 'Hold') {
    //         $DtoModel->dispatch_date = null;
    //     } else {
    //         $DtoModel->dispatch_date = $req->dispatch_date;
    //     }

    //     $DtoModel->remarks                 = $req->remarks; // NEW Remarks
    //     $DtoModel->updated_by              = Auth::user()->name;
    //     $DtoModel->updated_at              = $mytime;

    //     // 4. Handle Main PDF Update (If user uploads new file)
    //     if ($req->hasFile('upload_pdf')) {
    //         $file = $req->file('upload_pdf');

    //         // Generate Unique Name
    //         $regNumber = Str::upper($DtoModel->reg_number);
    //         $timestamp = now()->format('YmdHis');
    //         $pdfFileName = $regNumber . '_' . $timestamp . '_dto.' . $file->getClientOriginalExtension();

    //         // Move to folder
    //         $file->move(public_path('files'), $pdfFileName);

    //         // Update DB with NEW filename
    //         $DtoModel->upload_pdf = $pdfFileName;
    //     }

    //     // 5. Handle M-Parivahan Update (Optional)
    //     if ($req->status == 'Online') {
    //         $DtoModel->online_date = $req->online_date;

    //         if ($req->hasFile('upload_mparivahan')) {
    //             $file = $req->file('upload_mparivahan');
    //             $regNumber = Str::upper($DtoModel->reg_number);
    //             $mpariFileName = $regNumber . '_' . now()->format("YmdHis") . '_mpari.' . $file->getClientOriginalExtension();

    //             $file->move(public_path('files'), $mpariFileName);
    //             $DtoModel->upload_mparivahan = $mpariFileName;
    //         }
    //     }

    //     $DtoModel->save();

    //     // 6. SMS Logic
    //     if ($req->status == 'Online') {
    //         try {
    //             $this->smsService->sendCarTransferNotification(
    //                 $DtoModel->purchaser_name,
    //                 $DtoModel->Purchaser_mobile_number,
    //                 $DtoModel->reg_number,
    //                 $DtoModel->online_date
    //             );
    //         } catch (\Exception $e) {
    //             // Log error silently
    //         }
    //     }

    //     return redirect('admin/dto/view-dto-file')->with('success', 'File Updated Successfully & Old Version Archived.');
    // }

    public function updatedtofile(Request $req, $id)
    {
        // 1. Fetch Model FIRST (Needed to check if file already exists)
        $DtoModel = DtoModel::findOrFail($id);

        // 2. Dynamic Rule Logic
        // If Status is Online AND there is NO existing file in DB => Required
        // Otherwise => Nullable (Optional)
        $mParivahanRule = 'nullable';
        if ($req->status == 'Online' && empty($DtoModel->upload_mparivahan)) {
            $mParivahanRule = 'required';
        }

        // 3. Validation
        $req->validate([
            'Purchaser_mobile_number' => 'required|digits:10|regex:/^[6-9]\d{9}$/',
            'vendor_name'             => 'required|string|max:150',
            'vendor_mobile_number'    => 'required|digits:10|regex:/^[6-9]\d{9}$/',
            'rto_location'            => 'required|string',
            'dispatch_date'           => 'required_unless:status,Ready to Dispatch,Hold|nullable|date',
            'status'                  => 'required',
            'remarks'                 => 'required',
            // USE THE DYNAMIC RULE HERE:
            'upload_mparivahan'       => $mParivahanRule . '|mimes:png,jpg,jpeg,pdf|max:5120',
            'upload_pdf'              => 'nullable|mimes:pdf|max:10240',
            'purchaser_name'          => 'required|string|max:150',
            'financer'                => 'nullable|string',
            'challan_date'            => 'nullable|date',
            // Good practice: Ensure online_date is required if Online
            'online_date'             => 'required_if:status,Online|nullable|date',
        ], [
            // Custom error message for better UX
            'upload_mparivahan.required' => 'You must upload the M-Parivahan file when status is Online.',
        ]);

        $mytime = Carbon::now('Asia/Kolkata')->format('Y-m-d H:i:s');

        // ======================================================
        // 4. HISTORY TRACKING (Archive Old State)
        // ======================================================
        $history = new DtoFileHistoryModel;
        $history->dto_file_id = $DtoModel->id;
        $history->status      = $DtoModel->status;       // OLD Status
        $history->remarks     = $DtoModel->remarks;      // OLD Remarks

        // Only save the filename to history if the user is uploading a NEW file.
        if ($req->hasFile('upload_pdf')) {
            $history->file_name = $DtoModel->upload_pdf; // Save the file being replaced
        } else {
            $history->file_name = null; // No file change
        }

        $history->created_by  = Auth::user()->name;
        $history->created_at  = $mytime;
        $history->updated_at  = $mytime;
        $history->save();
        // ======================================================

        // 5. Update Fields
        $DtoModel->rto_location            = $req->rto_location;
        $DtoModel->purchaser_name          = $req->purchaser_name;
        $DtoModel->Purchaser_mobile_number = $req->Purchaser_mobile_number;
        $DtoModel->vendor_name             = $req->vendor_name;
        $DtoModel->vendor_mobile_number    = $req->vendor_mobile_number;

        // --- NEW FIELDS ---
        $DtoModel->financer                = $req->financer;
        $DtoModel->challan_date            = $req->challan_date;
        // ------------------

        $DtoModel->status                  = $req->status;

        // Logic: If status is 'Ready' or 'Hold', clear the dispatch date, otherwise save it
        if ($req->status === 'Ready to Dispatch' || $req->status === 'Hold') {
            $DtoModel->dispatch_date = null;
        } else {
            $DtoModel->dispatch_date = $req->dispatch_date;
        }

        $DtoModel->remarks                 = $req->remarks;
        $DtoModel->updated_by              = Auth::user()->name;
        $DtoModel->updated_at              = $mytime;

        // 6. Handle Main PDF Update (If user uploads new file)
        if ($req->hasFile('upload_pdf')) {
            $file = $req->file('upload_pdf');

            // Generate Unique Name
            $regNumber = Str::upper($DtoModel->reg_number);
            $timestamp = now()->format('YmdHis');
            $pdfFileName = $regNumber . '_' . $timestamp . '_dto.' . $file->getClientOriginalExtension();

            // Move to folder
            $file->move(public_path('files'), $pdfFileName);

            // Update DB with NEW filename
            $DtoModel->upload_pdf = $pdfFileName;
        }

        // 7. Handle M-Parivahan Update
        if ($req->status == 'Online') {
            $DtoModel->online_date = $req->online_date;

            if ($req->hasFile('upload_mparivahan')) {
                $file = $req->file('upload_mparivahan');
                $regNumber = Str::upper($DtoModel->reg_number);
                $mpariFileName = $regNumber . '_' . now()->format("YmdHis") . '_mpari.' . $file->getClientOriginalExtension();

                $file->move(public_path('files'), $mpariFileName);
                $DtoModel->upload_mparivahan = $mpariFileName;
            }
        }

        $DtoModel->save();

        // 8. SMS Logic
        if ($req->status == 'Online') {
            try {
                $this->smsService->sendCarTransferNotification(
                    $DtoModel->purchaser_name,
                    $DtoModel->Purchaser_mobile_number,
                    $DtoModel->reg_number,
                    $DtoModel->online_date
                );
            } catch (\Exception $e) {
                // Log error silently
            }
        }

        return redirect('admin/dto/view-dto-file')->with('success', 'File Updated Successfully & Old Version Archived.');
    }

    public function bulkUpdate(Request $req)
    {
        // 1. Validation
        $req->validate([
            'selected_ids'         => 'required|array', // Array of IDs to update
            'selected_ids.*'       => 'integer',
            'bulk_vendor_name'     => 'required|string',
            'bulk_vendor_mobile'   => 'required|numeric|digits:10',
            'bulk_dispatch_date'   => 'required|date',
        ]);

        try {
            // 2. Update All Selected Records
            DB::table('dto_dispatch') // Ensure this matches your table name
                ->whereIn('id', $req->selected_ids)
                ->update([
                    'vendor_name'          => $req->bulk_vendor_name,
                    'vendor_mobile_number' => $req->bulk_vendor_mobile,
                    'dispatch_date'        => $req->bulk_dispatch_date,
                    'status'               => "Dispatched",
                    'updated_by'           => Auth::user()->name,
                    'updated_at'           => now(),
                ]);

            return response()->json(['status' => 'success', 'message' => 'Records updated successfully!']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    // public function getdtolocation(Request $request)
    // {
    //     // 1. Handle Autocomplete Suggestions
    //     if ($request->has('term')) {
    //         $term = $request->input('term');
    //         $suggestions = DB::table('dto_code')
    //             ->where('code', 'LIKE', $term . '%')
    //             ->limit(10)
    //             ->get(['code as label', 'location as value']);
    //         return response()->json($suggestions);
    //     }

    //     // 2. Handle Direct Lookup & Duplicate Check
    //     $reg_number = $request->input('reg_number');
    //     $reg_prefix = strtoupper(substr(str_replace([' ', '-'], '', $reg_number), 0, 4));

    //     // Get Location
    //     $dto = DB::table('dto_code')->where('code', 'LIKE', $reg_prefix . '%')->first();

    //     // Check if registration number already exists in your files table
    //     // Replace 'dto_files' with your actual table name
    //     $exists = DB::table('dto_files')->where('reg_number', $reg_number)->exists();

    //     if ($dto) {
    //         return response()->json([
    //             'location' => $dto->location,
    //             'is_duplicate' => $exists
    //         ]);
    //     }

    //     return response()->json(['location' => 'Location not found', 'is_duplicate' => $exists], 404);
    // }

    public function getdtolocation(Request $request)
    {
        $reg_number = $request->input('reg_number');

        // Clean the input and get the first 4 characters (e.g., BR06)
        $prefix = strtoupper(substr(str_replace([' ', '-'], '', $reg_number), 0, 4));

        if (strlen($prefix) >= 4) {
            $result = DB::table('dto_code')
                ->where('code', $prefix)
                ->first();

            if ($result) {
                return response()->json([
                    'status' => 'success',
                    'location' => $result->location
                ]);
            }
        }

        return response()->json(['status' => 'error', 'message' => 'Not found'], 404);
    }
    
    public function softDeleteFunction($id)
    {
        // 1. FIXED Security Check: 
        // If User is NOT logged in OR User ID is NOT 1 -> Block them.
        if (!Auth::check() || Auth::id() != 1) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        // 2. Perform Manual Soft Delete
        // We added ->whereNull('deleted_at') so we don't overwrite the date 
        // if it was already deleted previously.
        $affected = DB::table('dto_dispatch')
            ->where('id', $id)
            ->whereNull('deleted_at') 
            ->update(['deleted_at' => Carbon::now()]); 

        if ($affected) {
            return redirect()->back()->with('success', 'File moved to trash successfully!');
        } else {
            return redirect()->back()->with('error', 'Record not found or already deleted.');
        }
    }
}
