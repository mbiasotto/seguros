<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Establishment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Obter o vendedor autenticado
        $vendor = Auth::guard('vendor')->user();

        // Contar estabelecimentos do vendedor
        $totalEstablishments = Establishment::where('vendor_id', $vendor->id)->count();

        // Contar estabelecimentos ativos do vendedor
        $activeEstablishments = Establishment::where('vendor_id', $vendor->id)
            ->where('ativo', true)
            ->count();

        // Define o intervalo de datas (Março 2024 a Fevereiro 2025)
        $startDate = Carbon::create(2024, 3, 1);
        $endDate = Carbon::create(2025, 2, 28);

        // Obter estabelecimentos registrados por mês para o intervalo de datas especificado
        $establishmentsPerMonth = Establishment::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as total')
        )
        ->where('vendor_id', $vendor->id)
        ->whereBetween('created_at', [$startDate, $endDate])
        ->groupBy('year', 'month')
        ->orderBy('year')
        ->orderBy('month')
        ->get()
        ->mapWithKeys(function ($item) {
            // Ajuste para criar uma chave única ano-mês
            return [sprintf('%04d-%02d', $item->year, $item->month) => ['year' => $item->year, 'month' => $item->month, 'total' => $item->total]];
        })
        ->toArray();

        // Inicializar array de dados mensais com zeros para todos os meses no intervalo
        $monthlyData = [];
        $currentDate = $startDate->copy();
        while ($currentDate->lessThanOrEqualTo($endDate)) {
            $monthlyData[$currentDate->format('Y-m')] = 0;
            $currentDate->addMonthNoOverflow();
        }

        // Preencher com valores reais onde existirem
        foreach ($establishmentsPerMonth as $key => $data) {
            $yearMonth = sprintf('%04d-%02d', $data['year'], $data['month']);
            if (isset($monthlyData[$yearMonth])) {
                $monthlyData[$yearMonth] = $data['total'];
            }
        }

        // Obter estabelecimentos recentes do vendedor
        $recentEstablishments = Establishment::where('vendor_id', $vendor->id)
            ->latest()
            ->take(5)
            ->get();

        return view('vendor.dashboard', compact(
            'vendor',
            'totalEstablishments',
            'activeEstablishments',
            'monthlyData',
            'recentEstablishments'
        ));
    }
}
