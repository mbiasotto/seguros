<?php

namespace App\Http\Controllers\Estabelecimento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EstabelecimentoDashboardController extends Controller
{
    /**
     * Dashboard do estabelecimento
     */
    public function index()
    {
        $estabelecimento = Auth::guard('estabelecimento')->user();

        // Calcular vendas de hoje (por enquanto simular)
        $vendasHoje = 0.00; // TODO: Implementar cálculo real das vendas

        return view('estabelecimento.dashboard.index', compact(
            'estabelecimento',
            'vendasHoje'
        ));
    }
}
