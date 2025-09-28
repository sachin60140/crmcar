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
        $data['car_stock']= DB::table('car_stock')->orderBy('reg_number', 'asc')->get();
        $data['stock_paper_cat']= DB::table('stock_doc_category')->orderBy('doc_type', 'asc')->get();

        $data['upload_paper'] = DB::table('car_stock_doc')->get();
        
        return view('admin.stock.add-stock-paper',$data);
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
                ->paginate(10);
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
}
