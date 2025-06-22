<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class RecargaPrepago extends Model
{
    use HasFactory;

    protected $table = 'recargas_prepago';

    protected $fillable = [
        'usuario_id',
        'valor',
        'forma_pagamento',
        'status',
        'comprovante_url',
        'confirmado_por_admin_id',
        'data_confirmacao',
    ];

    protected $casts = [
        'valor' => 'decimal:2',
        'data_confirmacao' => 'datetime',
    ];

    // Constantes para status
    const STATUS_PENDENTE = 'pendente';
    const STATUS_CONFIRMADO = 'confirmado';
    const STATUS_CANCELADO = 'cancelado';

    /**
     * Relacionamento com Usuario
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class);
    }

    /**
     * Relacionamento com Admin que confirmou
     */
    public function adminConfirmacao(): BelongsTo
    {
        return $this->belongsTo(User::class, 'confirmado_por_admin_id');
    }

    /**
     * Scope: Por status
     */
    public function scopeStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', $status);
    }

    /**
     * Scope: Pendentes
     */
    public function scopePendentes(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_PENDENTE);
    }

    /**
     * Scope: Confirmadas
     */
    public function scopeConfirmadas(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_CONFIRMADO);
    }

    /**
     * Scope: Canceladas
     */
    public function scopeCanceladas(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_CANCELADO);
    }

    /**
     * Verificar se está pendente
     */
    public function estaPendente(): bool
    {
        return $this->status === self::STATUS_PENDENTE;
    }

    /**
     * Verificar se foi confirmada
     */
    public function foiConfirmada(): bool
    {
        return $this->status === self::STATUS_CONFIRMADO;
    }

    /**
     * Verificar se foi cancelada
     */
    public function foiCancelada(): bool
    {
        return $this->status === self::STATUS_CANCELADO;
    }

    /**
     * Confirmar recarga
     */
    public function confirmar(int $adminId): void
    {
        $this->status = self::STATUS_CONFIRMADO;
        $this->confirmado_por_admin_id = $adminId;
        $this->data_confirmacao = now();
        $this->save();
    }

    /**
     * Cancelar recarga
     */
    public function cancelar(): void
    {
        $this->status = self::STATUS_CANCELADO;
        $this->save();
    }

    /**
     * Pode ser confirmada
     */
    public function podeSerConfirmada(): bool
    {
        return $this->estaPendente();
    }

    /**
     * Pode ser cancelada
     */
    public function podeSerCancelada(): bool
    {
        return $this->estaPendente();
    }
}
