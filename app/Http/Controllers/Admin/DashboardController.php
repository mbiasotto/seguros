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

        // Define the dynamic date range: current month and 11 preceding months (total 12 months)
        $endDate = Carbon::now()->endOfMonth();
        $startDate = Carbon::now()->subMonths(11)->startOfMonth(); // Current month + 11 previous months

        // Helper function to fetch and process monthly data
        $fetchMonthlyData = function ($query, $dateColumn = 'created_at') use ($startDate, $endDate) {
            $driverName = DB::connection()->getDriverName();
            $yearExpression = null;
            $monthExpression = null;

            if ($driverName === 'sqlite') {
                $yearExpression = DB::raw("strftime('%Y', {$dateColumn}) as year");
                $monthExpression = DB::raw("strftime('%m', {$dateColumn}) as month");
            } else { // Default to MySQL syntax (YEAR(), MONTH())
                $yearExpression = DB::raw("YEAR({$dateColumn}) as year");
                $monthExpression = DB::raw("MONTH({$dateColumn}) as month");
            }

            $results = $query->select(
                $yearExpression,
                $monthExpression,
                DB::raw('COUNT(*) as total')
            )
            ->whereBetween($dateColumn, [$startDate, $endDate])
            ->groupBy(DB::raw($driverName === 'sqlite' ? "strftime('%Y-%m', {$dateColumn})" : "year, month")) // Group by aliased year and month for MySQL too
            ->orderBy('year')
            ->orderBy('month')
            ->get()
            ->keyBy(function ($item) {
                // Ensure year and month are treated as strings for consistent key generation
                return sprintf('%04s-%02s', (string)$item->year, (string)$item->month);
            });

            $monthlyData = [];
            $currentPeriod = $startDate->copy();
            while ($currentPeriod->lessThanOrEqualTo($endDate)) {
                $key = $currentPeriod->format('Y-m'); // Format as YYYY-MM
                $monthlyData[$key] = $results->has($key) ? $results->get($key)->total : 0;
                $currentPeriod->addMonthNoOverflow();
            }
            return array_values($monthlyData);
        };

        // Get establishments registered per month
        $establishmentsQuery = Establishment::query();
        $establishmentsChartData = $fetchMonthlyData($establishmentsQuery, 'created_at');

        // Get documents data for the chart
        $documentsQuery = DB::table('establishment_onboardings')->whereNotNull('document_path');
        $documentsChartData = $fetchMonthlyData($documentsQuery, 'updated_at');

        // Get QR Code logs data for chart
        $qrLogsQuery = QrCodeAccessLog::query();
        $qrLogsChartData = $fetchMonthlyData($qrLogsQuery, 'created_at');

        // Prepare chart data for the view
        $chartData = [
            'establishments' => $establishmentsChartData,
            'documents' => $documentsChartData,
            'qr_logs' => $qrLogsChartData, // Added qr_logs here
        ];

        // Get recent establishments with vendor relationship
        $recentEstablishments = Establishment::with('vendor')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalEstablishments',
            'totalVendors',
            // 'monthlyData', // This is now part of $chartData['establishments']
            'recentEstablishments',
            'chartData' // Pass the consolidated chartData
            // 'qrLogsChartData' // This is now part of $chartData['qr_logs']
        ));
    }
}
