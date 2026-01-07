<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerLedgerModel;
use App\Models\CustomerStatementModel;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;


class CustomerLegderController extends Controller
{
    public function addledger()
    {
        return view('admin.ledger.add-ledger');
    }
    public function getLedgerDetails(Request $request)
    {
        $mobile = $request->mobile_number;

        // Search for the customer
        $customer = CustomerLedgerModel::where('mobile_number', $mobile)->first();

        if ($customer) {
            return response()->json([
                'found' => true,
                'data' => $customer
            ]);
        } else {
            return response()->json(['found' => false]);
        }
    }
    public function checkDuplicate(Request $request)
    {
        // 1. Map HTML input names to Database column names
        $columnMapping = [
            'aadhar'   => 'aadhar',   // Input 'aadhar' checks Column 'aadhar'
            'pan_card' => 'pan',      // Input 'pan_card' checks Column 'pan'
        ];

        $fieldName = $request->field_name;
        $value = $request->value;

        // 2. Check if the field is valid for checking
        if (array_key_exists($fieldName, $columnMapping)) {
            $dbColumn = $columnMapping[$fieldName];
            
            // 3. Query the database
            $exists = CustomerLedgerModel::where($dbColumn, $value)->exists();

            return response()->json(['exists' => $exists]);
        }

        return response()->json(['exists' => false]);
    }
    public function storeledger(Request $req)
    {
        $req->validate([
                
            'name' => 'required',
            'f_name' => 'required',
            'aadhar' => [
                        'required',
                        'numeric',
                        Rule::unique('ledger', 'aadhar'),
                        ],
            'pan_card' => [
                        'nullable',
                        Rule::unique('ledger', 'pan'),
                        ],
            'city' => 'required',
            'mobile_number' => [
                        'required',
                        'numeric',
                        Rule::unique('ledger', 'mobile_number'),
                        ],
            'address' => 'required',
        ]);
        $CustomerLedgerModel = new CustomerLedgerModel;

            $CustomerLedgerModel->Name = $req->name;
            $CustomerLedgerModel->f_name = $req->f_name;
            $CustomerLedgerModel->aadhar = $req->aadhar;
            $CustomerLedgerModel->pan = $req->pan_card;
            $CustomerLedgerModel->city = $req->city;
            $CustomerLedgerModel->mobile_number = $req->mobile_number;
            $CustomerLedgerModel->address = $req->address;
            $CustomerLedgerModel->created_by = Auth::user()->name;

            $CustomerLedgerModel->save();
            $lastid = $CustomerLedgerModel->id;
  
        return back()->with('success', ' Customer Ledger Added Successfully: ' .$lastid);
    }

    // public function viewledger()
    // {
    //     $data = DB::table('ledger')->get();
       
    //     return view('admin.ledger.view-ledger',compact('data'));
    // }
    public function viewledger()
    {
        // Optimized Query: Selects customer info AND calculates the sum in one go.
        // We assume your main customer table is named 'ledger' based on your previous code.
        $data = DB::table('ledger')
            ->addSelect([
                'total_amount' => DB::table('customer_ledger')
                    ->selectRaw('sum(amount)')
                    ->whereColumn('customer_id', 'ledger.id')
            ])
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.ledger.view-ledger', compact('data'));
    }

    public function viewledgerstatement($id)
    {
       $data['getRecords'] = CustomerStatementModel::getRecord($id);

        return view('admin.ledger.ledger-statement', $data);
    }

    public function reciept()
    {
        $data['clientlist'] = DB::table('ledger')
        ->select('id', 'name','mobile_number')
        ->orderBy('name', 'asc')
        ->get();
        return view('admin.ledger.reciept',$data);
    }
    public function storerecieptpayment(Request $req)
    {

        $req->validate([
                
            'client_name' => 'required',
            'paymentMode' => 'required',
            'txn_date' => 'required',
            'amount' => 'required',
            'remarks' => 'required',
        ]);

        $paymentmode= $req->paymentMode;

       $remrks= $paymentmode.'-'.'Payment Recived,'.'-'.$req->remarks; 

            $CustomerStatementModel = new CustomerStatementModel;

            $CustomerStatementModel->customer_id = $req->client_name;
            $CustomerStatementModel->payment_type = 1;
            $CustomerStatementModel->txn_date = $req->txn_date;
            $CustomerStatementModel->amount = $req->amount;
            $CustomerStatementModel->created_by = Auth::user()->name;
            $CustomerStatementModel->particular = $remrks;

            $CustomerStatementModel->save();
            $lastid = $CustomerStatementModel->id;
    
        return back()->with('success', ' Payment Reciept Successfully txn id is :  ' .$lastid);
    }


    public function getcustomerbalance(Request $req)
    {
        $custid = $req->post('customerid');

        $data = DB::table('customer_ledger')->where('customer_id', $custid)->sum('amount');

        echo 'Current Balance amount is: ' . '<b>' . $data . '</b>';
    }
}
