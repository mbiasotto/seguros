<?php

namespace App\Services;

use App\Models\Usuario;
use App\Models\Estabelecimento;
use App\Models\Transacao;
use Exception;
use Illuminate\Support\Facades\DB;

class TransacaoService
{
    protected SaldoService $saldoService;

    public function __construct(SaldoService $saldoService)
    {
        $this->saldoService = $saldoService;
    }

    /**
     * Criar uma nova transação
     */
    public function criarTransacao(Usuario $usuario, Estabelecimento $estabelecimento, float $valor): Transacao
    {
        // Verificar se tem saldo suficiente
        if (!$this->verificarSaldoSuficiente($usuario, $valor)) {
            throw new Exception('Saldo insuficiente');
        }

        return DB::transaction(function () use ($usuario, $estabelecimento, $valor) {
            $transacao = Transacao::create([
                'usuario_id' => $usuario->id,
                'estabelecimento_id' => $estabelecimento->id,
                'valor' => $valor,
                'pin' => $this->gerarPinUnico(),
                'status' => 'pendente',
                'expires_at' => now()->addMinutes(5),
            ]);

            return $transacao;
        });
    }

    /**
     * Autorizar uma transação com PIN
     */
    public function autorizarTransacao(Transacao $transacao, string $pinInformado): bool
    {
        // Verificar se transação já foi processada
        if ($transacao->status !== 'pendente') {
            throw new Exception('Transação já foi processada');
        }

        // Verificar se transação expirou
        if ($transacao->estaExpirada()) {
            throw new Exception('Transação expirada');
        }

        // Verificar PIN
        if (strtoupper($pinInformado) !== strtoupper($transacao->pin)) {
            throw new Exception('PIN incorreto');
        }

        // Re-verificar saldo no momento da confirmação
        if (!$this->verificarSaldoSuficiente($transacao->usuario, $transacao->valor)) {
            throw new Exception('Saldo insuficiente no momento da confirmação');
        }

        return DB::transaction(function () use ($transacao) {
            // Debitar valor dos saldos
            $this->saldoService->debitarValor($transacao->usuario, $transacao->valor, $transacao);

            // Autorizar transação
            $transacao->autorizar();

            return true;
        });
    }

    /**
     * Gerar PIN único de 6 dígitos
     */
    public function gerarPinUnico(): string
    {
        do {
            $pin = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        } while (Transacao::where('pin', $pin)->exists());

        return $pin;
    }

    /**
     * Verificar se o usuário tem saldo suficiente
     */
    public function verificarSaldoSuficiente(Usuario $usuario, float $valor): bool
    {
        $saldoTotal = $this->saldoService->calcularSaldoTotalDisponivel($usuario);
        return $saldoTotal >= $valor;
    }
}
