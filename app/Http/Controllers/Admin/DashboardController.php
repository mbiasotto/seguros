<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Establishment;
use App\Models\Vendor;
use App\Models\QrCodeAccessLog;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Get total counts
        $totalEstablishments = Establishment::count();
        $totalVendors = Vendor::count();

        // Define the date range (March 2024 to February 2025)
        $startDate = Carbon::create(2024, 3, 1);
        $endDate = Carbon::create(2025, 2, 28);

        // Get establishments registered per month for the specified date range
        $establishmentsPerMonth = Establishment::select(
            DB::raw('cast(strftime("%m", created_at) as integer) as month'),
            DB::raw('cast(strftime("%Y", created_at) as integer) as year'),
            DB::raw('COUNT(*) as total')
        )
        ->whereBetween('created_at', [$startDate, $endDate])
        ->groupBy('year', 'month')
        ->orderBy('year')
        ->orderBy('month')
        ->get()
        ->mapWithKeys(function ($item) {
            return [$item->month => $item->total];
        })
        ->toArray();

        // Initialize monthly data array with zeros for all months
        $monthlyData = array_fill(1, 12, 0);

        // Fill in actual values where they exist
        foreach ($establishmentsPerMonth as $month => $total) {
            $monthlyData[$month] = $total;
        }

        // Prepare chart data for the view
        $chartData = [
            'establishments' => array_values($monthlyData),
            'documents' => [] // We'll add document data later if needed
        ];

        // Get documents data for the chart
        $documentsPerMonth = DB::table('establishment_onboardings')
            ->select(
                DB::raw('cast(strftime("%m", updated_at) as integer) as month'),
                DB::raw('cast(strftime("%Y", updated_at) as integer) as year'),
                DB::raw('COUNT(*) as total')
            )
            ->whereNotNull('document_path')
            ->whereBetween('updated_at', [$startDate, $endDate])
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->month => $item->total];
            })
            ->toArray();

        // Initialize documents data array with zeros for all months
        $documentsData = array_fill(1, 12, 0);

        // Fill in actual values where they exist
        foreach ($documentsPerMonth as $month => $total) {
            $documentsData[$month] = $total;
        }

        // Add documents data to chart data
        $chartData['documents'] = array_values($documentsData);

        // Get QR Code logs data for chart
        $qrLogsPerMonth = QrCodeAccessLog::select(
            DB::raw('cast(strftime("%m", created_at) as integer) as month'),
            DB::raw('cast(strftime("%Y", created_at) as integer) as year'),
            DB::raw('COUNT(*) as total')
        )
        ->whereBetween('created_at', [$startDate, $endDate])
        ->groupBy('year', 'month')
        ->orderBy('year')
        ->orderBy('month')
        ->get()
        ->mapWithKeys(function ($item) {
            return [$item->month => $item->total];
        })
        ->toArray();

        // Initialize QR logs data array with zeros for all months
        $qrLogsData = array_fill(1, 12, 0);

        // Fill in actual values where they exist
        foreach ($qrLogsPerMonth as $month => $total) {
            $qrLogsData[$month] = $total;
        }

        // Prepare QR logs chart data for the view
        $qrLogsChartData = array_values($qrLogsData);

        // Get recent establishments with vendor relationship
        $recentEstablishments = Establishment::with('vendor')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalEstablishments',
            'totalVendors',
            'monthlyData',
            'recentEstablishments',
            'chartData',
            'qrLogsChartData'
        ));
    }
}
