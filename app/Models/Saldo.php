<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class Saldo extends Model
{
    use HasFactory;

    protected $table = 'saldos';

    protected $fillable = [
        'usuario_id',
        'tipo',
        'valor_disponivel',
        'valor_original',
        'data_credito',
        'data_expiracao',
        'status'
    ];

    protected $casts = [
        'valor_disponivel' => 'decimal:2',
        'valor_original' => 'decimal:2',
        'data_credito' => 'datetime',
        'data_expiracao' => 'datetime',
    ];

    // Constantes para tipos
    const TIPO_PRE_PAGO = 'pre_pago';
    const TIPO_MENSALIDADE = 'mensalidade';
    const TIPO_LIMITE_CONSIGNADO = 'limite_consignado';

    // Constantes para status
    const STATUS_ATIVO = 'ativo';
    const STATUS_UTILIZADO = 'utilizado';
    const STATUS_EXPIRADO = 'expirado';

    /**
     * Relacionamento com Usuario
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class);
    }

    /**
     * Relacionamento com MovimentacaoSaldo
     */
    public function movimentacoes(): HasMany
    {
        return $this->hasMany(MovimentacaoSaldo::class);
    }

    /**
     * Scope: Saldos ativos
     */
    public function scopeAtivos(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_ATIVO)
                    ->where(function ($q) {
                        $q->whereNull('data_expiracao')
                          ->orWhere('data_expiracao', '>', now());
                    });
    }

    /**
     * Scope: Por tipo
     */
    public function scopeTipo(Builder $query, string $tipo): Builder
    {
        return $query->where('tipo', $tipo);
    }

    /**
     * Scope: Com saldo disponível
     */
    public function scopeComSaldo(Builder $query): Builder
    {
        return $query->where('valor_disponivel', '>', 0);
    }

    /**
     * Verifica se o saldo está ativo (não expirado e com valor)
     */
    public function estaAtivo(): bool
    {
        if ($this->status !== self::STATUS_ATIVO) {
            return false;
        }

        if ($this->valor_disponivel <= 0) {
            return false;
        }

        if ($this->data_expiracao && $this->data_expiracao->isPast()) {
            return false;
        }

        return true;
    }

    /**
     * Debitar valor do saldo
     */
    public function debitar(float $valor, string $descricao = null, int $transacaoId = null): MovimentacaoSaldo
    {
        if (!$this->estaAtivo()) {
            throw new \Exception('Saldo não está ativo para débito');
        }

        if ($valor > $this->valor_disponivel) {
            throw new \Exception('Valor de débito maior que saldo disponível');
        }

        $saldoAnterior = $this->valor_disponivel;
        $this->valor_disponivel -= $valor;

        // Atualizar status se valor zerou
        if ($this->valor_disponivel <= 0) {
            $this->status = self::STATUS_UTILIZADO;
        }

        $this->save();

        // Criar movimentação
        return $this->movimentacoes()->create([
            'transacao_id' => $transacaoId,
            'tipo_movimentacao' => 'debito',
            'valor' => $valor,
            'descricao' => $descricao ?? "Débito de saldo {$this->tipo}",
            'saldo_anterior' => $saldoAnterior,
            'saldo_posterior' => $this->valor_disponivel,
        ]);
    }

    /**
     * Creditar valor no saldo
     */
    public function creditar(float $valor, string $descricao = null): MovimentacaoSaldo
    {
        $saldoAnterior = $this->valor_disponivel;
        $this->valor_disponivel += $valor;

        // Se estava utilizado, volta para ativo
        if ($this->status === self::STATUS_UTILIZADO && $this->valor_disponivel > 0) {
            $this->status = self::STATUS_ATIVO;
        }

        $this->save();

        // Criar movimentação
        return $this->movimentacoes()->create([
            'tipo_movimentacao' => 'credito',
            'valor' => $valor,
            'descricao' => $descricao ?? "Crédito em saldo {$this->tipo}",
            'saldo_anterior' => $saldoAnterior,
            'saldo_posterior' => $this->valor_disponivel,
        ]);
    }

    /**
     * Marcar como expirado
     */
    public function expirar(): void
    {
        $this->status = self::STATUS_EXPIRADO;
        $this->save();
    }
}
