<?php

namespace App\Http\Controllers\Establishment;

use App\Http\Controllers\Controller;
use App\Models\QrCodeAccessLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $establishment = Auth::guard('establishment')->user();

        // Obter QR codes vinculados ao estabelecimento
        $qrCodes = $establishment->qrCodes;
        $qrCodeIds = $qrCodes->pluck('id');

        // Total de QR codes vinculados
        $totalQrCodes = $qrCodes->count();

        // Total de acessos aos QR codes do estabelecimento
        $totalQrCodeAccesses = QrCodeAccessLog::whereIn('qr_code_id', $qrCodeIds)->count();

        // Acessos hoje
        $accessesToday = QrCodeAccessLog::whereIn('qr_code_id', $qrCodeIds)
            ->whereDate('created_at', Carbon::today())
            ->count();

        // Acessos esta semana
        $accessesThisWeek = QrCodeAccessLog::whereIn('qr_code_id', $qrCodeIds)
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->count();

        // Define o intervalo de datas: mês atual e 11 meses anteriores (total 12 meses)
        $endDate = Carbon::now()->endOfMonth();
        $startDate = Carbon::now()->subMonths(11)->startOfMonth();

        // Dados para gráfico de acessos mensais
        $monthlyAccesses = $this->getMonthlyQrCodeAccesses($qrCodeIds, $startDate, $endDate);

        // Estatísticas por QR Code
        $qrCodeStats = [];
        foreach ($qrCodes as $qrCode) {
            $qrCodeStats[] = [
                'qr_code' => $qrCode,
                'total_accesses' => QrCodeAccessLog::where('qr_code_id', $qrCode->id)->count(),
                'accesses_today' => QrCodeAccessLog::where('qr_code_id', $qrCode->id)
                    ->whereDate('created_at', Carbon::today())
                    ->count(),
                'accesses_this_week' => QrCodeAccessLog::where('qr_code_id', $qrCode->id)
                    ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                    ->count(),
            ];
        }

        // Acessos recentes (últimos 10)
        $recentAccesses = QrCodeAccessLog::whereIn('qr_code_id', $qrCodeIds)
            ->with('qrCode')
            ->latest()
            ->take(10)
            ->get();

        return view('establishment.dashboard', compact(
            'establishment',
            'totalQrCodes',
            'totalQrCodeAccesses',
            'accessesToday',
            'accessesThisWeek',
            'monthlyAccesses',
            'qrCodeStats',
            'recentAccesses'
        ));
    }

    /**
     * Obter dados de acessos mensais aos QR codes
     */
    private function getMonthlyQrCodeAccesses($qrCodeIds, $startDate, $endDate)
    {
        $driverName = DB::connection()->getDriverName();

        if ($driverName === 'sqlite') {
            $yearExpression = DB::raw("strftime('%Y', created_at) as year");
            $monthExpression = DB::raw("strftime('%m', created_at) as month");
            $groupExpression = DB::raw("strftime('%Y-%m', created_at)");
        } else {
            $yearExpression = DB::raw("YEAR(created_at) as year");
            $monthExpression = DB::raw("MONTH(created_at) as month");
            $groupExpression = DB::raw("year, month");
        }

        $results = QrCodeAccessLog::select(
            $yearExpression,
            $monthExpression,
            DB::raw('COUNT(*) as total')
        )
        ->whereIn('qr_code_id', $qrCodeIds)
        ->whereBetween('created_at', [$startDate, $endDate])
        ->groupBy($groupExpression)
        ->orderBy('year')
        ->orderBy('month')
        ->get()
        ->keyBy(function ($item) {
            return sprintf('%04s-%02s', (string)$item->year, (string)$item->month);
        });

        // Preencher todos os meses no intervalo
        $monthlyData = [];
        $currentPeriod = $startDate->copy();

        while ($currentPeriod->lessThanOrEqualTo($endDate)) {
            $key = $currentPeriod->format('Y-m');
            $monthlyData[$key] = $results->has($key) ? $results->get($key)->total : 0;
            $currentPeriod->addMonthNoOverflow();
        }

        return array_values($monthlyData);
    }
}
