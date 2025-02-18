<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Establishment;
use App\Models\Vendor;
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

        // Get recent establishments with vendor relationship
        $recentEstablishments = Establishment::with('vendor')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalEstablishments',
            'totalVendors',
            'monthlyData',
            'recentEstablishments'
        ));
    }
}
