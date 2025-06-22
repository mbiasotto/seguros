<?php

namespace App\Services;

use App\Models\Usuario;
use App\Models\Saldo;
use App\Models\RecargaPrepago;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SaldoService
{
    /**
     * Adicionar crédito pré-pago para usuário
     */
    public function adicionarCreditoPrePago(Usuario $usuario, float $valor, string $descricao = null): Saldo
    {
        return DB::transaction(function () use ($usuario, $valor, $descricao) {
            $saldo = $usuario->saldos()->create([
                'tipo' => Saldo::TIPO_PRE_PAGO,
                'valor_disponivel' => $valor,
                'valor_original' => $valor,
                'data_credito' => now(),
                'data_expiracao' => null, // Pré-pago não expira
                'status' => Saldo::STATUS_ATIVO,
            ]);

            // Criar movimentação de crédito inicial
            $saldo->movimentacoes()->create([
                'transacao_id' => null,
                'tipo_movimentacao' => 'credito',
                'valor' => $valor,
                'descricao' => $descricao ?? 'Crédito pré-pago adicionado',
                'saldo_anterior' => 0,
                'saldo_posterior' => $valor,
            ]);

            return $saldo;
        });
    }

    /**
     * Processar mensalidade do usuário (criar saldo tipo mensalidade)
     */
    public function processarMensalidade(Usuario $usuario): ?Saldo
    {
        // Verificar se ainda está em período gratuito
        if ($usuario->estaEmPeriodoGratuito()) {
            return null;
        }

        // Verificar se tem valor de mensalidade definido
        if ($usuario->valor_mensalidade <= 0) {
            return null;
        }

        return DB::transaction(function () use ($usuario) {
            $saldo = $usuario->saldos()->create([
                'tipo' => Saldo::TIPO_MENSALIDADE,
                'valor_disponivel' => $usuario->valor_mensalidade,
                'valor_original' => $usuario->valor_mensalidade,
                'data_credito' => now(),
                'data_expiracao' => now()->addMonth(), // Mensalidade expira em 1 mês
                'status' => Saldo::STATUS_ATIVO,
            ]);

            // Criar movimentação de crédito inicial
            $saldo->movimentacoes()->create([
                'transacao_id' => null,
                'tipo_movimentacao' => 'credito',
                'valor' => $usuario->valor_mensalidade,
                'descricao' => 'Mensalidade processada',
                'saldo_anterior' => 0,
                'saldo_posterior' => $usuario->valor_mensalidade,
            ]);

            return $saldo;
        });
    }

    /**
     * Criar saldo de limite consignado baseado no limite_disponivel existente
     */
    public function criarSaldoLimiteConsignado(Usuario $usuario): ?Saldo
    {
        if ($usuario->limite_disponivel <= 0) {
            return null;
        }

        // Verificar se já existe saldo de limite consignado ativo
        $saldoExistente = $usuario->saldos()
            ->ativos()
            ->tipo(Saldo::TIPO_LIMITE_CONSIGNADO)
            ->first();

        if ($saldoExistente) {
            return $saldoExistente;
        }

        return DB::transaction(function () use ($usuario) {
            $saldo = $usuario->saldos()->create([
                'tipo' => Saldo::TIPO_LIMITE_CONSIGNADO,
                'valor_disponivel' => $usuario->limite_disponivel,
                'valor_original' => $usuario->limite_disponivel,
                'data_credito' => now(),
                'data_expiracao' => null, // Limite não expira
                'status' => Saldo::STATUS_ATIVO,
            ]);

            // Criar movimentação de crédito inicial
            $saldo->movimentacoes()->create([
                'transacao_id' => null,
                'tipo_movimentacao' => 'credito',
                'valor' => $usuario->limite_disponivel,
                'descricao' => 'Limite consignado disponibilizado',
                'saldo_anterior' => 0,
                'saldo_posterior' => $usuario->limite_disponivel,
            ]);

            return $saldo;
        });
    }

    /**
     * Obter ordem de débito dos saldos (prioridade)
     * 1º Pré-pago, 2º Mensalidade, 3º Limite Consignado
     */
    public function obterOrdemDebito(Usuario $usuario): \Illuminate\Database\Eloquent\Collection
    {
        return $usuario->saldos()
            ->ativos()
            ->comSaldo()
            ->orderByRaw("
                CASE tipo
                    WHEN 'pre_pago' THEN 1
                    WHEN 'mensalidade' THEN 2
                    WHEN 'limite_consignado' THEN 3
                    ELSE 4
                END
            ")
            ->orderBy('data_credito', 'asc') // Mais antigo primeiro
            ->get();
    }

    /**
     * Debitar valor seguindo ordem de prioridade dos saldos
     */
    public function debitarValor(Usuario $usuario, float $valor, $transacao = null): array
    {
        $saldoTotal = $this->calcularSaldoTotalDisponivel($usuario);

        if ($saldoTotal < $valor) {
            throw new \Exception('Saldo insuficiente para débito');
        }

        $saldos = $this->obterOrdemDebito($usuario);
        $valorRestante = $valor;
        $movimentacoes = [];
        $breakdown = [];

        return DB::transaction(function () use ($saldos, $valorRestante, $transacao, &$movimentacoes, &$breakdown, $valor) {
            foreach ($saldos as $saldo) {
                if ($valorRestante <= 0) {
                    break;
                }

                $valorDebitar = min($valorRestante, $saldo->valor_disponivel);

                if ($valorDebitar > 0) {
                    $saldoAnterior = $saldo->valor_disponivel;
                    $saldo->valor_disponivel -= $valorDebitar;
                    $saldo->save();

                    $descricao = $transacao
                        ? "Pagamento para {$transacao->estabelecimento->nome_fantasia} - #{$transacao->id}"
                        : 'Débito automático';

                    $movimentacao = $saldo->movimentacoes()->create([
                        'transacao_id' => $transacao ? $transacao->id : null,
                        'tipo_movimentacao' => 'debito',
                        'valor' => $valorDebitar,
                        'descricao' => $descricao,
                        'saldo_anterior' => $saldoAnterior,
                        'saldo_posterior' => $saldo->valor_disponivel,
                    ]);

                    $movimentacoes[] = $movimentacao;

                    $breakdown[] = [
                        'tipo' => $saldo->tipo,
                        'valor_debitado' => $valorDebitar,
                        'saldo_anterior' => $saldoAnterior,
                        'saldo_posterior' => $saldo->valor_disponivel,
                    ];

                    $valorRestante -= $valorDebitar;
                }
            }

            if ($valorRestante > 0) {
                throw new \Exception('Erro ao processar débito: valor restante não debitado');
            }

            return $transacao ? $breakdown : $movimentacoes;
        });
    }

    /**
     * Calcular saldo total disponível do usuário
     */
    public function calcularSaldoTotalDisponivel(Usuario $usuario): float
    {
        return $usuario->saldos()
            ->ativos()
            ->comSaldo()
            ->sum('valor_disponivel');
    }

    /**
     * Verificar se tem saldo suficiente
     */
    public function temSaldoSuficiente(Usuario $usuario, float $valor): bool
    {
        return $this->calcularSaldoTotalDisponivel($usuario) >= $valor;
    }

    /**
     * Consultar saldo detalhado do usuário
     */
    public function consultarSaldoDetalhado(Usuario $usuario): array
    {
        $saldos = $usuario->saldos()->ativos()->comSaldo()->get();

        $prePago = $saldos->where('tipo', Saldo::TIPO_PRE_PAGO)->sum('valor_disponivel');
        $mensalidade = $saldos->where('tipo', Saldo::TIPO_MENSALIDADE)->sum('valor_disponivel');
        $limiteConsignado = $saldos->where('tipo', Saldo::TIPO_LIMITE_CONSIGNADO)->sum('valor_disponivel');

        return [
            'pre_pago' => $prePago,
            'mensalidade' => $mensalidade,
            'limite_consignado' => $limiteConsignado,
            'saldo_total' => $prePago + $mensalidade + $limiteConsignado,
            'saldos_detalhados' => [
                'pre_pago' => [
                    'total' => $prePago,
                    'saldos' => $saldos->where('tipo', Saldo::TIPO_PRE_PAGO)->values(),
                ],
                'mensalidade' => [
                    'total' => $mensalidade,
                    'saldos' => $saldos->where('tipo', Saldo::TIPO_MENSALIDADE)->values(),
                ],
                'limite_consignado' => [
                    'total' => $limiteConsignado,
                    'saldos' => $saldos->where('tipo', Saldo::TIPO_LIMITE_CONSIGNADO)->values(),
                ],
            ],
            'periodo_gratuito' => [
                'ativo' => $usuario->estaEmPeriodoGratuito(),
                'data_fim' => $usuario->data_fim_gratuidade,
                'meses_restantes' => $usuario->data_fim_gratuidade
                    ? now()->diffInMonths($usuario->data_fim_gratuidade)
                    : 0,
            ],
        ];
    }

    /**
     * Processar confirmação de recarga pré-pago
     */
    public function confirmarRecargaPrepago(RecargaPrepago $recarga, int $adminId): Saldo
    {
        if (!$recarga->podeSerConfirmada()) {
            throw new \Exception('Recarga não pode ser confirmada');
        }

        return DB::transaction(function () use ($recarga, $adminId) {
            // Confirmar a recarga
            $recarga->confirmar($adminId);

            // Adicionar crédito pré-pago
            return $this->adicionarCreditoPrePago(
                $recarga->usuario,
                $recarga->valor,
                "Recarga pré-pago confirmada - #{$recarga->id}"
            );
        });
    }

    /**
     * Expirar saldos vencidos
     */
    public function expirarSaldosVencidos(): int
    {
        $saldosExpirados = Saldo::where('status', Saldo::STATUS_ATIVO)
            ->whereNotNull('data_expiracao')
            ->where('data_expiracao', '<', now())
            ->get();

        foreach ($saldosExpirados as $saldo) {
            $saldo->expirar();
        }

        return $saldosExpirados->count();
    }

    /**
     * Migrar limite disponível existente para novo sistema de saldos
     */
    public function migrarLimiteExistente(Usuario $usuario): ?Saldo
    {
        // Verificar se já foi migrado
        $jaTemSaldoLimite = $usuario->saldos()
            ->tipo(Saldo::TIPO_LIMITE_CONSIGNADO)
            ->exists();

        if ($jaTemSaldoLimite) {
            return null;
        }

        return $this->criarSaldoLimiteConsignado($usuario);
    }

    /**
     * Criar saldo de mensalidade com valor específico
     */
    public function criarSaldoMensalidade(Usuario $usuario, float $valor, string $descricao = null): Saldo
    {
        return DB::transaction(function () use ($usuario, $valor, $descricao) {
            $saldo = $usuario->saldos()->create([
                'tipo' => Saldo::TIPO_MENSALIDADE,
                'valor_disponivel' => $valor,
                'valor_original' => $valor,
                'data_credito' => now(),
                'data_expiracao' => now()->addMonth(), // Mensalidade expira em 1 mês
                'status' => Saldo::STATUS_ATIVO,
            ]);

            // Criar movimentação de crédito inicial
            $saldo->movimentacoes()->create([
                'transacao_id' => null,
                'tipo_movimentacao' => 'credito',
                'valor' => $valor,
                'descricao' => $descricao ?? 'Mensalidade processada',
                'saldo_anterior' => 0,
                'saldo_posterior' => $valor,
            ]);

            return $saldo;
        });
    }
}
