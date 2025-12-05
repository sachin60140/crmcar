<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\StockFileModel;
use Illuminate\Pagination\LengthAwarePaginator;

class UploadStockPaperController extends Controller
{
    public function addstockpaper()
    {
        $data['car_stock'] = DB::table('car_stock')->orderBy('reg_number', 'asc')->get();
        $data['stock_paper_cat'] = DB::table('stock_doc_category')->orderBy('doc_type', 'asc')->get();

        $data['upload_paper'] = DB::table('car_stock_doc')->get();

        return view('admin.stock.add-stock-paper', $data);
    }

    public function storestockpaper(Request $request)
    {
        $request->validate([
            'reg_number' => 'required',
            'doc_type' => 'required',
            'stock_doc' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10480', // Adjust file types and size as needed
        ]);

        $reg_number = $request->input('reg_number');
        $doc_type = $request->input('doc_type');
        $files = $request->file('stock_doc');

        if ($request->hasFile('stock_doc')) {
            $fileName1 = $reg_number . '_' . $doc_type;
            $fileName = time() . '_' . $fileName1 . '.' . $files->getClientOriginalExtension();
            $filePath = $files->storeAs('uploads/stock_papers', $fileName, 'public');
            $files->move('uploads/stock_papers', $fileName);

            DB::table('car_stock_doc')->insert([
                'Reg_no' => $reg_number,
                'doc_type' => $doc_type,
                'file_path' => $filePath,
                'file_name' => $fileName,
                'created_at' => now(),
                'created_by' => auth()->user()->name,
                'updated_at' => now(),
            ]);
        }


        return redirect()->back()->with('success', 'Stock papers uploaded successfully.');
    }

    public function viewstockpaper(Request $request)
    {

        $query = $request->input('query');

        // Check if the query is not empty before searching
        if (!empty($query)) {
            // If a query exists, perform the search and paginate the results
            $files = StockFileModel::query()
                ->where('Reg_no', 'LIKE', "%{$query}%")
                ->latest()
                ->paginate(25);
        } else {
            // If there's no query, create an empty paginator instance.
            // This ensures the $files variable is always a paginator object,
            // preventing errors in the view when calling ->links().
            $files = new LengthAwarePaginator([], 0, 10);
        }

        return view('admin.stock.view-stock-paper', compact('files', 'query'));
    }

    public function downloadfile($id)
    {
        $file = StockFileModel::findOrFail($id);

        // Construct the full path to the file in the storage directory
        $filePath = storage_path('app/public/' . $file->file_path);

        // Verify the file exists before attempting download
        if (!file_exists($filePath)) {
            abort(404, 'File not found.');
        }

        // Use Laravel's download response to send the file
        return response()->download($filePath, $file->filename);
    }

    function stockpaperdetails()
    {
        // 1. Fetch all data
        $allRecords = StockFileModel::all();

        // 2. Group by Vehicle Number (Reg_no) first
        $groupedByVehicle = $allRecords->groupBy('Reg_no');

        // 3. SORT LEVEL 1 (Vehicles): 
        // Put the vehicle with the most recent upload (Highest ID) at the top
        $sortedVehicles = $groupedByVehicle->sortByDesc(function ($vehicleRecords) {
            return $vehicleRecords->max('id');
        });

        $tableData = [];

        // 4. Loop through the sorted vehicles
        foreach ($sortedVehicles as $vehicleNo => $vehicleRecords) {
            
            // 5. Group by Document Type inside this vehicle
            $docTypes = $vehicleRecords->groupBy('doc_type');

            // --- CHANGED HERE: SORT LEVEL 2 (Document Types) ---
            // Sort the categories (keys) A-Z (e.g., Insurance, Pollution, RC)
            $sortedDocTypes = $docTypes->sortKeys(); 

            foreach ($sortedDocTypes as $type => $records) {
                
                // --- SORT LEVEL 3 (Files) ---
                // Sort the individual files A-Z by name
                $sortedDocs = $records->sortBy('file_name', SORT_NATURAL | SORT_FLAG_CASE);

                // Generate HTML Buttons
                $buttonsHtml = $sortedDocs->map(function($item) {
                    
                    $url = asset($item->file_path);
                    $ext = strtolower(pathinfo($item->file_path, PATHINFO_EXTENSION));

                    // Truncate long names
                    $displayName = strlen($item->file_name) > 15 
                                   ? substr($item->file_name, 0, 15) . '...' 
                                   : $item->file_name;

                    return '<button type="button" 
                                data-file-url="'.$url.'" 
                                data-file-type="'.$ext.'"
                                title="'.$item->file_name.'"
                                class="btn btn-sm btn-outline-primary btn-preview me-1 mb-1 shadow-sm">
                                <i class="bi bi-file-earmark-text"></i> '.$displayName.'
                            </button>';
                })->implode(' '); 

                $tableData[] = [
                    'vehicle_number' => $vehicleNo,
                    'document_type'  => $type,
                    'attachments'    => $buttonsHtml 
                ];
            }
        }
        
        return view('admin.stock.stock-paper-details', ['data' => $tableData]);
    }
}
