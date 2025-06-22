<?php

namespace App\Services;

use App\Models\Usuario;
use App\Models\Faturamento;
use App\Models\Transacao;
use App\Models\MovimentacaoSaldo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Exception;

class FaturamentoService
{
    private SaldoService $saldoService;

    public function __construct(SaldoService $saldoService)
    {
        $this->saldoService = $saldoService;
    }

    /**
     * Processa mensalidade de um usuário específico
     */
    public function processarMensalidadeUsuario(Usuario $usuario): array
    {
        $mesReferencia = now()->format('Y-m');

        // Verificar se já foi processado
        $faturamentoExistente = Faturamento::where('usuario_id', $usuario->id)
            ->where('mes_referencia', $mesReferencia)
            ->first();

        if ($faturamentoExistente) {
            // Atualizar conta CPFL se necessário
            if ($faturamentoExistente->conta_cpfl !== $usuario->conta_cpfl) {
                $faturamentoExistente->update(['conta_cpfl' => $usuario->conta_cpfl]);
            }

            return [
                'deve_cobrar' => false,
                'motivo' => 'Mensalidade já processada para este mês',
                'valor_cobrado' => 0,
            ];
        }

        // Verificar período gratuito
        if ($this->usuarioEstaEmPeriodoGratuito($usuario)) {
            return [
                'deve_cobrar' => false,
                'motivo' => 'Usuário ainda está no período gratuito',
                'valor_cobrado' => 0,
            ];
        }

        // Calcular valor (proporcional se for parcial)
        $valorMensalidade = $this->calcularValorMensalidade($usuario);

        // Criar/atualizar faturamento
        $faturamento = $this->criarOuAtualizarFaturamento($usuario, $mesReferencia, $valorMensalidade);

        // Criar saldo tipo mensalidade
        $this->saldoService->criarSaldoMensalidade($usuario, $valorMensalidade, 'Mensalidade ' . now()->format('m/Y'));

        Log::info("Mensalidade processada para usuário {$usuario->id}: R$ {$valorMensalidade}");

        return [
            'deve_cobrar' => true,
            'valor_cobrado' => $valorMensalidade,
            'faturamento_id' => $faturamento->id,
        ];
    }

    /**
     * Processa mensalidades de todos os usuários
     */
    public function processarTodasMensalidades(): array
    {
        $usuarios = Usuario::where('status', 'ativo')->get();
        $usuariosProcessados = 0;
        $mensalidadesGeradas = 0;
        $valorTotalGerado = 0;

        foreach ($usuarios as $usuario) {
            $usuariosProcessados++;

            $resultado = $this->processarMensalidadeUsuario($usuario);

            if ($resultado['deve_cobrar']) {
                $mensalidadesGeradas++;
                $valorTotalGerado += $resultado['valor_cobrado'];
            }
        }

        return [
            'usuarios_processados' => $usuariosProcessados,
            'mensalidades_geradas' => $mensalidadesGeradas,
            'valor_total_gerado' => $valorTotalGerado,
        ];
    }

    /**
     * Fecha o faturamento de um mês
     */
    public function fecharMes(string $mesReferencia): array
    {
        // Não permitir fechar mês atual
        if ($mesReferencia === now()->format('Y-m')) {
            throw new Exception('Não é possível fechar o mês atual');
        }

        // Verificar se já foi fechado
        $jaFechado = Faturamento::doMes($mesReferencia)
            ->fechados()
            ->exists();

        if ($jaFechado) {
            throw new Exception('Mês já foi fechado');
        }

        // Buscar todos os faturamentos do mês
        $faturamentos = Faturamento::doMes($mesReferencia)
            ->comStatus('aberto')
            ->get();

        $totalUsuarios = $faturamentos->count();
        $totalTransacoes = 0;
        $valorTotalTransacoes = 0;

        foreach ($faturamentos as $faturamento) {
            // Calcular transações do mês
            $transacoes = $this->buscarTransacoesDoMes($faturamento->usuario_id, $mesReferencia);
            $valorTransacoes = $transacoes->sum('valor');
            $totalTransacoes += $transacoes->count();
            $valorTotalTransacoes += $valorTransacoes;

            // Atualizar faturamento
            $faturamento->update([
                'valor_transacoes' => $valorTransacoes,
                'valor_total' => $valorTransacoes + $faturamento->valor_mensalidade,
            ]);

            // Fechar faturamento
            $faturamento->fechar();
        }

        Log::info("Mês {$mesReferencia} fechado: {$totalUsuarios} usuários, {$totalTransacoes} transações, R$ {$valorTotalTransacoes}");

        return [
            'total_usuarios' => $totalUsuarios,
            'total_transacoes' => $totalTransacoes,
            'valor_total_transacoes' => $valorTotalTransacoes,
        ];
    }

    /**
     * Gera arquivo CPFL para um mês
     */
    public function gerarArquivoCPFL(string $mesReferencia): array
    {
        // Buscar faturamentos fechados
        $faturamentos = Faturamento::doMes($mesReferencia)
            ->fechados()
            ->whereNotNull('conta_cpfl')
            ->get();

        if ($faturamentos->isEmpty()) {
            throw new Exception('Não há faturamentos fechados para o mês');
        }

        // Gerar conteúdo do arquivo
        $conteudo = '';
        $vencimento = $this->calcularDataVencimento($mesReferencia);

        foreach ($faturamentos as $faturamento) {
            $linha = sprintf(
                "%s|%.2f|%s|%s\n",
                $faturamento->conta_cpfl,
                $faturamento->valor_total,
                $vencimento,
                $mesReferencia
            );
            $conteudo .= $linha;
        }

        // Salvar arquivo
        $nomeArquivo = "cpfl_multiplic_{$mesReferencia}.txt";
        $caminhoRelativo = "cpfl/{$nomeArquivo}";
        $caminhoCompleto = storage_path("app/{$caminhoRelativo}");

        // Criar diretório se não existir
        if (!is_dir(dirname($caminhoCompleto))) {
            mkdir(dirname($caminhoCompleto), 0755, true);
        }

        file_put_contents($caminhoCompleto, trim($conteudo));

        // Atualizar faturamentos
        foreach ($faturamentos as $faturamento) {
            $faturamento->atualizarArquivoCPFL();
            $faturamento->marcarComoEnviado();
        }

        Log::info("Arquivo CPFL gerado para {$mesReferencia}: {$faturamentos->count()} registros");

        return [
            'caminho_arquivo' => $caminhoCompleto,
            'total_registros' => $faturamentos->count(),
            'nome_arquivo' => $nomeArquivo,
        ];
    }

    /**
     * Métodos auxiliares privados
     */
    private function usuarioEstaEmPeriodoGratuito(Usuario $usuario): bool
    {
        // Usar método existente do model Usuario
        return $usuario->estaEmPeriodoGratuito();
    }

    private function calcularValorMensalidade(Usuario $usuario): float
    {
        $valorMensal = $usuario->valor_mensalidade ?? config('app.mensalidade_padrao', 29.90);

        // Se o usuário foi criado no mês atual, calcular proporcional
        if ($usuario->created_at->format('Y-m') === now()->format('Y-m')) {
            $diasRestantes = now()->endOfMonth()->day - $usuario->created_at->day + 1;
            $diasTotais = now()->endOfMonth()->day;
            $valorMensal = ($valorMensal * $diasRestantes) / $diasTotais;
        }

        return round($valorMensal, 2);
    }

    private function criarOuAtualizarFaturamento(Usuario $usuario, string $mesReferencia, float $valorMensalidade): Faturamento
    {
        return Faturamento::updateOrCreate(
            [
                'usuario_id' => $usuario->id,
                'mes_referencia' => $mesReferencia,
            ],
            [
                'valor_mensalidade' => $valorMensalidade,
                'conta_cpfl' => $usuario->conta_cpfl,
                'status' => 'aberto',
            ]
        );
    }

    private function buscarTransacoesDoMes(int $usuarioId, string $mesReferencia)
    {
        $inicioMes = Carbon::createFromFormat('Y-m', $mesReferencia)->startOfMonth();
        $fimMes = Carbon::createFromFormat('Y-m', $mesReferencia)->endOfMonth();

        return Transacao::where('usuario_id', $usuarioId)
            ->where('status', 'autorizada')
            ->whereBetween('authorized_at', [$inicioMes, $fimMes])
            ->get();
    }

    private function calcularDataVencimento(string $mesReferencia): string
    {
        $diaVencimento = config('app.cpfl_vencimento_dia', 10);
        $proximoMes = Carbon::createFromFormat('Y-m', $mesReferencia)->addMonth();

        return $proximoMes->setDay($diaVencimento)->format('Y-m-d');
    }
}
