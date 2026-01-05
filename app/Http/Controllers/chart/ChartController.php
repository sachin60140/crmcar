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
    public function chartData()
    {
        // Generate last 6 months list (including current month)
        $months = collect();
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months->push([
                'month_num' => $date->month,
                'year'      => $date->year,
                'label'     => $date->format('M Y'), // e.g. Jan 2025
            ]);
        }

        // Booking data
        $bookingData = DB::table('car_booking')
            ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total')
            ->where('created_at', '>=', Carbon::now()->subMonths(5)->startOfMonth())
            ->groupBy('year', 'month')
            ->get()
            ->keyBy(fn($row) => $row->year . '-' . $row->month);

        // Delivery data
        $deliveryData = DB::table('car_delivary')
            ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total')
            ->where('created_at', '>=', Carbon::now()->subMonths(5)->startOfMonth())
            ->groupBy('year', 'month')
            ->get()
            ->keyBy(fn($row) => $row->year . '-' . $row->month);

        // Prepare final chart arrays
        $labels   = [];
        $booking  = [];
        $delivery = [];

        foreach ($months as $m) {
            $key = $m['year'] . '-' . $m['month_num'];

            $labels[]   = $m['label'];
            $booking[]  = $bookingData[$key]->total  ?? 0;
            $delivery[] = $deliveryData[$key]->total ?? 0;
        }

        return response()->json([
            'labels'   => $labels,
            'booking'  => $booking,
            'delivery' => $delivery,
        ]);
    }

    public function getOnlineReportData()
    {
        // 1. Define the time range (Last 6 months)
        $startDate = Carbon::now()->subMonths(5)->startOfMonth(); // Go back 5 months + current month
        $endDate   = Carbon::now()->endOfMonth();

        // 2. Query Database: Group by Year-Month and Count
        $queryData = DB::table('dto_dispatch')
            ->select(
                DB::raw("DATE_FORMAT(online_date, '%Y-%m') as month_key"),
                DB::raw("COUNT(*) as total")
            )
            ->where('status', 'Online')
            ->whereBetween('online_date', [$startDate, $endDate])
            ->groupBy('month_key')
            ->orderBy('month_key', 'ASC')
            ->pluck('total', 'month_key'); // Creates an array like ['2025-09' => 5, '2025-10' => 12]

        // 3. Prepare Final Arrays (Filling in missing months with 0)
        $labels = [];
        $data   = [];

        // Loop through the last 6 months to create the structure
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthKey = $date->format('Y-m'); // Key to match DB result (e.g., "2025-09")
            $monthName = $date->format('M Y'); // Label for Chart (e.g., "Sep 2025")

            $labels[] = $monthName;
            // If data exists for this month, use it; otherwise, use 0
            $data[] = isset($queryData[$monthKey]) ? $queryData[$monthKey] : 0;
        }

        return response()->json([
            'labels' => $labels,
            'data'   => $data,
        ]);
    }
}
