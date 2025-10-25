<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardDataController extends Controller
{
    public function fetchData(Request $request)
    {
        // Example logic to fetch dashboard data

        $qkonnect_contacts = DB::table('qkonnect_data')->distinct('caller_number')->count('caller_number');
        $today_qkonnect_contacts = DB::table('qkonnect_data')->whereDate('created_at', Carbon::today())->count();

        return response()->json([
            'total_qkonnect_data' => $qkonnect_contacts,
            'today_qkonnect_contacts'=> $today_qkonnect_contacts,
        ]);
    }
}
