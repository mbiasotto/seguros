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
            DB::raw('cast(strftime("%m", created_at) as integer) as month'),
            DB::raw('cast(strftime("%Y", created_at) as integer) as year'),
            DB::raw('COUNT(*) as total')
        )
        ->where('vendor_id', $vendor->id)
        ->whereBetween('created_at', [$startDate, $endDate])
        ->groupBy('year', 'month')
        ->orderBy('year')
        ->orderBy('month')
        ->get()
        ->mapWithKeys(function ($item) {
            return [$item->month => $item->total];
        })
        ->toArray();

        // Inicializar array de dados mensais com zeros para todos os meses
        $monthlyData = array_fill(1, 12, 0);

        // Preencher com valores reais onde existirem
        foreach ($establishmentsPerMonth as $month => $total) {
            $monthlyData[$month] = $total;
        }

        // Obter estabelecimentos recentes do vendedor
        $recentEstablishments = Establishment::where('vendor_id', $vendor->id)
            ->latest()
            ->take(5)
            ->get();

        return view('vendor.dashboard', compact(
            'totalEstablishments',
            'activeEstablishments',
            'monthlyData',
            'recentEstablishments'
        ));
    }
}