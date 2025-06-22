<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Faturamento extends Model
{
    use HasFactory;

    protected $table = 'faturamentos';

    protected $fillable = [
        'usuario_id',
        'mes_referencia',
        'valor_transacoes',
        'valor_mensalidade',
        'valor_total',
        'conta_cpfl',
        'status',
        'arquivo_cpfl_gerado_em',
        'enviado_em',
        'pago_em',
    ];

    protected $casts = [
        'valor_transacoes' => 'decimal:2',
        'valor_mensalidade' => 'decimal:2',
        'valor_total' => 'decimal:2',
        'arquivo_cpfl_gerado_em' => 'datetime',
        'enviado_em' => 'datetime',
        'pago_em' => 'datetime',
    ];

    /**
     * Relacionamento com usuário
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class);
    }

    /**
     * Relacionamento com transações do mês
     */
    public function transacoes(): HasMany
    {
        $inicioMes = Carbon::createFromFormat('Y-m', $this->mes_referencia)->startOfMonth();
        $fimMes = Carbon::createFromFormat('Y-m', $this->mes_referencia)->endOfMonth();

        return $this->hasMany(Transacao::class, 'usuario_id', 'usuario_id')
            ->where('status', 'confirmada')
            ->whereBetween('authorized_at', [$inicioMes, $fimMes]);
    }

    /**
     * Relacionamento com movimentações de saldo do mês
     */
    public function movimentacoesSaldo(): HasMany
    {
        $inicioMes = Carbon::createFromFormat('Y-m', $this->mes_referencia)->startOfMonth();
        $fimMes = Carbon::createFromFormat('Y-m', $this->mes_referencia)->endOfMonth();

        return $this->hasMany(MovimentacaoSaldo::class, 'usuario_id', 'usuario_id')
            ->whereBetween('created_at', [$inicioMes, $fimMes]);
    }

    /**
     * Scopes
     */
    public function scopeDoMes($query, string $mesReferencia)
    {
        return $query->where('mes_referencia', $mesReferencia);
    }

    public function scopeComStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function scopeFechados($query)
    {
        return $query->whereIn('status', ['fechado', 'enviado', 'pago']);
    }

    public function scopeEnviados($query)
    {
        return $query->whereIn('status', ['enviado', 'pago']);
    }

    public function scopePagos($query)
    {
        return $query->where('status', 'pago');
    }

    /**
     * Métodos auxiliares
     */
    public function estaFechado(): bool
    {
        return in_array($this->status, ['fechado', 'enviado', 'pago']);
    }

    public function foiEnviado(): bool
    {
        return in_array($this->status, ['enviado', 'pago']);
    }

    public function foiPago(): bool
    {
        return $this->status === 'pago';
    }

    public function podeSerFechado(): bool
    {
        return $this->status === 'aberto';
    }

    public function podeGerarArquivoCPFL(): bool
    {
        return $this->status === 'fechado';
    }

    /**
     * Marca como fechado
     */
    public function fechar(): bool
    {
        if (!$this->podeSerFechado()) {
            return false;
        }

        $this->status = 'fechado';
        return $this->save();
    }

    /**
     * Marca como enviado
     */
    public function marcarComoEnviado(): bool
    {
        if (!$this->podeGerarArquivoCPFL()) {
            return false;
        }

        $this->status = 'enviado';
        $this->enviado_em = now();
        return $this->save();
    }

    /**
     * Marca como pago
     */
    public function marcarComoPago(): bool
    {
        if (!$this->foiEnviado()) {
            return false;
        }

        $this->status = 'pago';
        $this->pago_em = now();
        return $this->save();
    }

    /**
     * Atualiza arquivo CPFL gerado
     */
    public function atualizarArquivoCPFL(): void
    {
        $this->arquivo_cpfl_gerado_em = now();
        $this->save();
    }

    /**
     * Calcula o valor total
     */
    public function calcularValorTotal(): float
    {
        return $this->valor_transacoes + $this->valor_mensalidade;
    }

    /**
     * Formata o mês de referência para exibição
     */
    public function getMesReferenciaFormatadoAttribute(): string
    {
        $data = Carbon::createFromFormat('Y-m', $this->mes_referencia);
        return $data->translatedFormat('F/Y');
    }

    /**
     * Retorna o mês anterior
     */
    public static function mesAnterior(): string
    {
        return now()->subMonth()->format('Y-m');
    }

    /**
     * Retorna o mês atual
     */
    public static function mesAtual(): string
    {
        return now()->format('Y-m');
    }
}
