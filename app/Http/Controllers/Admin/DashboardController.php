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
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as total')
        )
        ->whereBetween('created_at', [$startDate, $endDate])
        ->groupBy('year', 'month')
        ->orderBy('year')
        ->orderBy('month')
        ->get()
        ->mapWithKeys(function ($item) {
            return [sprintf('%04d-%02d', $item->year, $item->month) => ['year' => $item->year, 'month' => $item->month, 'total' => $item->total]];
        })
        ->toArray();

        // Initialize monthly data array with zeros for all months in the range
        $monthlyData = [];
        $currentDate = $startDate->copy();
        while ($currentDate->lessThanOrEqualTo($endDate)) {
            $monthlyData[$currentDate->format('Y-m')] = 0;
            $currentDate->addMonthNoOverflow();
        }

        // Fill in actual values where they exist
        foreach ($establishmentsPerMonth as $key => $data) {
            $yearMonth = sprintf('%04d-%02d', $data['year'], $data['month']);
            if (isset($monthlyData[$yearMonth])) {
                $monthlyData[$yearMonth] = $data['total'];
            }
        }

        // Prepare chart data for the view
        $chartData = [
            'establishments' => array_values($monthlyData),
            'documents' => [] // We'll add document data later if needed
        ];

        // Get documents data for the chart
        $documentsPerMonth = DB::table('establishment_onboardings')
            ->select(
                DB::raw('YEAR(updated_at) as year'),
                DB::raw('MONTH(updated_at) as month'),
                DB::raw('COUNT(*) as total')
            )
            ->whereNotNull('document_path')
            ->whereBetween('updated_at', [$startDate, $endDate])
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get()
            ->mapWithKeys(function ($item) {
                return [sprintf('%04d-%02d', $item->year, $item->month) => ['year' => $item->year, 'month' => $item->month, 'total' => $item->total]];
            })
            ->toArray();

        // Initialize documents data array with zeros for all months in the range
        $documentsData = [];
        $currentDate = $startDate->copy();
        while ($currentDate->lessThanOrEqualTo($endDate)) {
            $documentsData[$currentDate->format('Y-m')] = 0;
            $currentDate->addMonthNoOverflow();
        }

        // Fill in actual values where they exist
        foreach ($documentsPerMonth as $key => $data) {
            $yearMonth = sprintf('%04d-%02d', $data['year'], $data['month']);
            if (isset($documentsData[$yearMonth])) {
                $documentsData[$yearMonth] = $data['total'];
            }
        }

        // Add documents data to chart data
        // Ensure the order matches the initialized array keys
        $chartData['documents'] = array_values($documentsData);

        // Get QR Code logs data for chart
        $qrLogsPerMonth = QrCodeAccessLog::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as total')
        )
        ->whereBetween('created_at', [$startDate, $endDate])
        ->groupBy('year', 'month')
        ->orderBy('year')
        ->orderBy('month')
        ->get()
        ->mapWithKeys(function ($item) {
            return [sprintf('%04d-%02d', $item->year, $item->month) => ['year' => $item->year, 'month' => $item->month, 'total' => $item->total]];
        })
        ->toArray();

        // Initialize QR logs data array with zeros for all months in the range
        $qrLogsData = [];
        $currentDate = $startDate->copy();
        while ($currentDate->lessThanOrEqualTo($endDate)) {
            $qrLogsData[$currentDate->format('Y-m')] = 0;
            $currentDate->addMonthNoOverflow();
        }

        // Fill in actual values where they exist
        foreach ($qrLogsPerMonth as $key => $data) {
            $yearMonth = sprintf('%04d-%02d', $data['year'], $data['month']);
            if (isset($qrLogsData[$yearMonth])) {
                $qrLogsData[$yearMonth] = $data['total'];
            }
        }

        // Prepare QR logs chart data for the view
        // Ensure the order matches the initialized array keys
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
