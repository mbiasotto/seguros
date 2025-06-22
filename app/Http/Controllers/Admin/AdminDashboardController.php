<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Estabelecimento;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Estatísticas gerais básicas
        $totalEstablishments = Estabelecimento::count();
        $totalUsers = Cliente::count();
        $totalCategories = Categoria::count();

        // Estabelecimentos recentes
        $recentEstablishments = Estabelecimento::with('categoria')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Dados para gráficos (últimos 12 meses) - apenas estabelecimentos
        $months = collect();
        for ($i = 11; $i >= 0; $i--) {
            $months->push(Carbon::now()->subMonths($i));
        }

        $establishmentsData = [];
        $usersData = [];

        foreach ($months as $month) {
            $monthStart = $month->startOfMonth()->copy();
            $monthEnd = $month->endOfMonth()->copy();

            // Estabelecimentos cadastrados no mês
            $establishmentsCount = Estabelecimento::whereBetween('created_at', [$monthStart, $monthEnd])->count();
            $establishmentsData[] = $establishmentsCount;

            // Usuários cadastrados no mês
            $usersCount = Cliente::whereBetween('created_at', [$monthStart, $monthEnd])->count();
            $usersData[] = $usersCount;
        }

        $chartData = [
            'establishments' => $establishmentsData,
            'users' => $usersData
        ];

        return view('admin.dashboard', compact(
            'totalEstablishments',
            'totalUsers',
            'totalCategories',
            'recentEstablishments',
            'chartData'
        ));
    }

    /**
     * Página de relatórios
     */
    public function relatorios()
    {
        $stats = [
            'usuarios_total' => Cliente::count(),
            'usuarios_ativos' => Cliente::where('status', 'ativo')->count(),
            'usuarios_bloqueados' => Cliente::where('status', 'bloqueado')->count(),
            'estabelecimentos_total' => Estabelecimento::count(),
            'estabelecimentos_ativos' => Estabelecimento::where('status', 'ativo')->count(),
        ];

        return view('admin.relatorios.index', compact('stats'));
    }

    /**
     * Relatório de faturamento
     */
    public function relatorioFaturamento()
    {
        // Aqui você pode implementar a lógica de faturamento
        $faturamento = [
            'total_mes' => 0,
            'total_ano' => 0,
            'comissoes_pagas' => 0,
            'comissoes_pendentes' => 0,
        ];

        return view('admin.relatorios.faturamento', compact('faturamento'));
    }

    /**
     * Página de configurações
     */
    public function configuracoes()
    {
        // Aqui você pode buscar configurações do sistema
        $configuracoes = [
            'sistema_nome' => 'Sistema de Gestão',
            'sistema_email' => 'admin@sistema.com',
            'notificacoes_ativas' => true,
            'manutencao_ativa' => false,
        ];

        return view('admin.configuracoes.index', compact('configuracoes'));
    }

    /**
     * Salvar configurações
     */
    public function salvarConfiguracoes(Request $request)
    {
        $request->validate([
            'sistema_nome' => 'required|string|max:255',
            'sistema_email' => 'required|email|max:255',
        ]);

        // Aqui você implementaria a lógica para salvar as configurações
        // Por exemplo, em uma tabela de configurações ou cache

        return redirect()->route('admin.configuracoes.index')
            ->with('success', 'Configurações salvas com sucesso!');
    }
}
