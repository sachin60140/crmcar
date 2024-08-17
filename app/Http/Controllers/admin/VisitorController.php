<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class VisitorController extends Controller
{
    public function vistordata()
    {
        $data['visitordata'] = DB::table('visitor')->get();
        return view('admin.visitor.view-visitor-data',$data); 
    }
}
