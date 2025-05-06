<?php

namespace App\Http\Controllers;

use App\Models\QrCode;
use App\Models\QrCodeAccessLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QrCodeStatisticsController extends Controller
{
    /**
     * Exibe a página de estatísticas gerais
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // Total de acessos
        $totalAccesses = QrCodeAccessLog::count();

        // Total de acessos nos últimos 7 dias
        $lastWeekAccesses = QrCodeAccessLog::where('created_at', '>=', Carbon::now()->subDays(7))->count();

        // Total de acessos nos últimos 30 dias
        $lastMonthAccesses = QrCodeAccessLog::where('created_at', '>=', Carbon::now()->subDays(30))->count();

        // QR Codes mais acessados
        $topQrCodes = QrCode::withCount('accessLogs')
            ->orderByDesc('access_logs_count')
            ->take(10)
            ->get();

        // Acessos por dia nos últimos 30 dias
        $dailyStats = QrCodeAccessLog::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as date"),
                DB::raw('COUNT(*) as total')
            )
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('qrcode.statistics.index', compact(
            'totalAccesses',
            'lastWeekAccesses',
            'lastMonthAccesses',
            'topQrCodes',
            'dailyStats'
        ));
    }

    /**
     * Exibe estatísticas detalhadas de um QR code específico
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $qrCode = QrCode::with(['establishments'])->findOrFail($id);

        // Total de acessos
        $totalAccesses = $qrCode->accessLogs()->count();

        // Acessos por período
        $lastDayAccesses = $qrCode->accessLogs()->where('created_at', '>=', Carbon::now()->subDay())->count();
        $lastWeekAccesses = $qrCode->accessLogs()->where('created_at', '>=', Carbon::now()->subDays(7))->count();
        $lastMonthAccesses = $qrCode->accessLogs()->where('created_at', '>=', Carbon::now()->subDays(30))->count();

        // Acessos por dia
        $dailyStats = $qrCode->accessLogs()
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as date"),
                DB::raw('COUNT(*) as total')
            )
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Acessos por hora do dia
        $hourlyStats = $qrCode->accessLogs()
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%H') as hour"),
                DB::raw('COUNT(*) as total')
            )
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('hour')
            ->orderBy('hour')
            ->get();

        // Últimos 20 acessos
        $recentAccesses = $qrCode->accessLogs()
            ->orderByDesc('created_at')
            ->take(20)
            ->get();

        return view('qrcode.statistics.show', compact(
            'qrCode',
            'totalAccesses',
            'lastDayAccesses',
            'lastWeekAccesses',
            'lastMonthAccesses',
            'dailyStats',
            'hourlyStats',
            'recentAccesses'
        ));
    }
}
