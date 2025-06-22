<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contrato extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'numero_contrato',
        'tipo',
        'documento_identidade_url',
        'status',
        'enviado_cpfl_em',
        'protocolo_cpfl',
        'protocolo_cancelamento',
        'score_inicial',
        'limite_inicial',
        'data_proxima_revisao_score',
    ];

    protected $casts = [
        'data_proxima_revisao_score' => 'date',
        'enviado_cpfl_em' => 'datetime',
        'limite_inicial' => 'decimal:2',
    ];

    // Constantes de status
    const STATUS_PENDENTE_CPFL = 'pendente_cpfl';
    const STATUS_ATIVO = 'ativo';
    const STATUS_CANCELADO = 'cancelado';

    // Constantes de tipo
    const TIPO_SITE = 'site';
    const TIPO_AVULSO = 'avulso';

    /**
     * Relacionamento com Usuario
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class);
    }

    /**
     * Verifica se o contrato está ativo
     */
    public function estaAtivo(): bool
    {
        return $this->status === self::STATUS_ATIVO;
    }

    /**
     * Verifica se o contrato pode ser cancelado
     */
    public function podeSerCancelado(): bool
    {
        return in_array($this->status, [self::STATUS_PENDENTE_CPFL, self::STATUS_ATIVO]);
    }

    /**
     * Verifica se precisa de revisão de score
     */
    public function precisaRevisaoScore(): bool
    {
        if (!$this->data_proxima_revisao_score) {
            return false;
        }

        return $this->data_proxima_revisao_score <= now()->toDateString();
    }

    /**
     * Scope para contratos ativos
     */
    public function scopeAtivos($query)
    {
        return $query->where('status', self::STATUS_ATIVO);
    }

    /**
     * Scope para contratos pendentes CPFL
     */
    public function scopePendentesCpfl($query)
    {
        return $query->where('status', self::STATUS_PENDENTE_CPFL);
    }

    /**
     * Scope para contratos cancelados
     */
    public function scopeCancelados($query)
    {
        return $query->where('status', self::STATUS_CANCELADO);
    }

    /**
     * Scope por tipo
     */
    public function scopeTipo($query, string $tipo)
    {
        return $query->where('tipo', $tipo);
    }
}
