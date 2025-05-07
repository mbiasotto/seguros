<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Establishment;
use App\Models\QrCodeAccessLog; // Added
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $vendor = Auth::guard('vendor')->user();
        $vendorId = $vendor->id;

        // Total counts for the vendor
        $totalEstablishments = Establishment::where('vendor_id', $vendorId)->count();
        // $activeEstablishments logic removed

        // Total QR Code Accesses for the vendor's establishments
        $totalQrCodeAccesses = DB::table('qr_code_access_logs')
            ->join('establishment_qr_code', 'qr_code_access_logs.qr_code_id', '=', 'establishment_qr_code.qr_code_id')
            ->join('establishments', 'establishment_qr_code.establishment_id', '=', 'establishments.id')
            ->where('establishments.vendor_id', $vendorId)
            ->count();

        // Define the dynamic date range: current month and 11 preceding months (total 12 months)
        $endDate = Carbon::now()->endOfMonth();
        $startDate = Carbon::now()->subMonths(11)->startOfMonth();

        // Helper function to fetch and process monthly data
        $fetchMonthlyData = function ($baseQuery, $dateColumn = 'created_at', $isQrLog = false) use ($startDate, $endDate, $vendorId) {
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

            $query = $baseQuery->select(
                $yearExpression,
                $monthExpression,
                DB::raw('COUNT(*) as total')
            )
            ->whereBetween($dateColumn, [$startDate, $endDate]);

            // Simplified groupBy logic, as it's the same for both cases
            // The specific $dateColumn (e.g., 'establishments.created_at' or 'qr_code_access_logs.created_at')
            // is correctly passed into the strftime or used with YEAR()/MONTH()
            $query->groupBy(DB::raw($driverName === 'sqlite' ? "strftime('%Y-%m', {$dateColumn})" : "year, month"));

            $results = $query->orderBy('year')
                            ->orderBy('month')
                            ->get()
                            ->keyBy(function ($item) {
                                return sprintf('%04s-%02s', (string)$item->year, (string)$item->month);
                            });

            $monthlyDataArr = [];
            $currentPeriod = $startDate->copy();
            while ($currentPeriod->lessThanOrEqualTo($endDate)) {
                $key = $currentPeriod->format('Y-m');
                $monthlyDataArr[$key] = $results->has($key) ? $results->get($key)->total : 0;
                $currentPeriod->addMonthNoOverflow();
            }
            return array_values($monthlyDataArr);
        };

        // Get establishments registered per month for the vendor
        $establishmentsBaseQuery = Establishment::where('vendor_id', $vendorId);
        $establishmentsChartData = $fetchMonthlyData($establishmentsBaseQuery, 'establishments.created_at');

        // Get QR Code logs data for chart for the vendor
        $qrLogsBaseQuery = DB::table('qr_code_access_logs')
            ->join('establishment_qr_code', 'qr_code_access_logs.qr_code_id', '=', 'establishment_qr_code.qr_code_id')
            ->join('establishments', 'establishment_qr_code.establishment_id', '=', 'establishments.id')
            ->where('establishments.vendor_id', $vendorId);
        $qrLogsChartData = $fetchMonthlyData($qrLogsBaseQuery, 'qr_code_access_logs.created_at', true);

        // Prepare chart data for the view
        $chartData = [
            'establishments' => $establishmentsChartData,
            'qr_logs' => $qrLogsChartData,
        ];

        // Get recent establishments for the vendor
        $recentEstablishments = Establishment::where('vendor_id', $vendorId)
            ->latest()
            ->take(5)
            ->get();

        return view('vendor.dashboard', compact(
            'vendor',
            'totalEstablishments',
            // 'activeEstablishments', // Removed
            'totalQrCodeAccesses',
            'chartData',
            'recentEstablishments'
        ));
    }
}
