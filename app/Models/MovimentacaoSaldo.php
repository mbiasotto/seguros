<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class MovimentacaoSaldo extends Model
{
    use HasFactory;

    protected $table = 'movimentacoes_saldo';

    protected $fillable = [
        'saldo_id',
        'transacao_id',
        'tipo_movimentacao',
        'valor',
        'descricao',
        'saldo_anterior',
        'saldo_posterior',
    ];

    protected $casts = [
        'valor' => 'decimal:2',
        'saldo_anterior' => 'decimal:2',
        'saldo_posterior' => 'decimal:2',
    ];

    // Constantes para tipos de movimentação
    const TIPO_CREDITO = 'credito';
    const TIPO_DEBITO = 'debito';

    /**
     * Relacionamento com Saldo
     */
    public function saldo(): BelongsTo
    {
        return $this->belongsTo(Saldo::class);
    }

    /**
     * Relacionamento com Transacao
     */
    public function transacao(): BelongsTo
    {
        return $this->belongsTo(Transacao::class);
    }

    /**
     * Scope: Por tipo de movimentação
     */
    public function scopeTipo(Builder $query, string $tipo): Builder
    {
        return $query->where('tipo_movimentacao', $tipo);
    }

    /**
     * Scope: Créditos
     */
    public function scopeCreditos(Builder $query): Builder
    {
        return $query->where('tipo_movimentacao', self::TIPO_CREDITO);
    }

    /**
     * Scope: Débitos
     */
    public function scopeDebitos(Builder $query): Builder
    {
        return $query->where('tipo_movimentacao', self::TIPO_DEBITO);
    }

    /**
     * Scope: Por período
     */
    public function scopePorPeriodo(Builder $query, $dataInicio, $dataFim): Builder
    {
        return $query->whereBetween('created_at', [$dataInicio, $dataFim]);
    }

    /**
     * Verificar se é crédito
     */
    public function ehCredito(): bool
    {
        return $this->tipo_movimentacao === self::TIPO_CREDITO;
    }

    /**
     * Verificar se é débito
     */
    public function ehDebito(): bool
    {
        return $this->tipo_movimentacao === self::TIPO_DEBITO;
    }

    /**
     * Obter diferença de saldo
     */
    public function getDiferencaSaldoAttribute(): float
    {
        return $this->saldo_posterior - $this->saldo_anterior;
    }
}
