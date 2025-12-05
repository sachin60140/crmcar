<?php

namespace App\Http\Controllers\chart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\CarDelivaryModel;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function getChartData()
    {
        // Get last 6 months dates
        $months = [];
        $data = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $months[] = $month->format('M Y');

            // Example: Count records for each month
            $count = CarDelivaryModel::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();

            $data[] = $count;

            // Alternative: For aggregated data like sales
            // $total = YourModel::whereYear('created_at', $month->year)
            //     ->whereMonth('created_at', $month->month)
            //     ->sum('amount');
            // $data[] = $total;
        }

        return response()->json([
            'months' => $months,
            'data' => $data
        ]);
    }
     public function index()
    {
        // Example: count records month-wise
        $chartData = DB::table('car_delivary')
            ->selectRaw("MONTHNAME(created_at) as month, COUNT(id) as total")
            ->groupBy('month')
            ->orderByRaw("MIN(created_at)")
            ->get();

        // Prepare labels & values for ChartJS
        $labels = $chartData->pluck('month');
        $values = $chartData->pluck('total');

        return view('admin.dashboard', compact('labels', 'values'));
    }

    public function newChartData()
    {
        $fromDate = now()->subMonths(5)->startOfMonth();

        $chartData = DB::table('car_delivary')
        ->selectRaw("
            DATE_FORMAT(created_at, '%b %Y') as month_year,
            YEAR(created_at) as year,
            MONTH(created_at) as month,
            COUNT(id) as total
        ")
        ->where('created_at', '>=', $fromDate)
        ->groupBy('year', 'month', 'month_year')
        ->orderBy('year')
        ->orderBy('month')
        ->get();

    // Labels like: ["Jul 2025", "Aug 2025", ...]
    $labels = $chartData->pluck('month_year');

    // Values like: [10, 5, 20, ...]
    $values = $chartData->pluck('total');

    return response()->json([
        'labels' => $labels,
        'values' => $values,
    ]);
    }
}
