<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Services\SaldoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsuarioDashboardController extends Controller
{
    protected $saldoService;

    public function __construct(SaldoService $saldoService)
    {
        $this->saldoService = $saldoService;
    }

    /**
     * Dashboard do usuário
     */
    public function index()
    {
        $usuario = Auth::guard('usuario')->user();

        // Obter informações detalhadas dos saldos
        $saldosDetalhados = $this->saldoService->consultarSaldoDetalhado($usuario);

        // Calcular valores individuais
        $saldoPrePago = $usuario->getSaldoPrePagoAttribute();
        $saldoMensalidade = $usuario->getSaldoMensalidadeAttribute();
        $saldoLimiteConsignado = $usuario->getSaldoLimiteConsignadoAttribute();
        $saldoTotal = $usuario->getSaldoTotalAttribute();

        // Obter histórico recente (últimas 10 movimentações)
        $historicoRecente = $usuario->saldos()
            ->with('movimentacoes')
            ->get()
            ->flatMap(function ($saldo) {
                return $saldo->movimentacoes;
            })
            ->sortByDesc('created_at')
            ->take(10);

        return view('usuario.dashboard.index', compact(
            'usuario',
            'saldoPrePago',
            'saldoMensalidade',
            'saldoLimiteConsignado',
            'saldoTotal',
            'saldosDetalhados',
            'historicoRecente'
        ));
    }
}
