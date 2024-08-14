<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function addfinancefile()
    {
        $data['financer_list'] = DB::table('financer_details')->orderBy('financer_name','asc')->get();
        return view('admin.finance.add-finance', $data);
    }
}
