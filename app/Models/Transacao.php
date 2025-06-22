<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Transacao extends Model
{
    use HasFactory;

    protected $table = 'transacoes';

    protected $fillable = [
        'usuario_id',
        'estabelecimento_id',
        'valor',
        'pin',
        'status',
        'expires_at',
        'authorized_at',
    ];

    protected $casts = [
        'valor' => 'decimal:2',
        'expires_at' => 'datetime',
        'authorized_at' => 'datetime',
    ];

    /**
     * Relacionamentos
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class);
    }

    public function estabelecimento(): BelongsTo
    {
        return $this->belongsTo(Estabelecimento::class);
    }

    public function movimentacoes(): HasMany
    {
        return $this->hasMany(MovimentacaoSaldo::class);
    }

    /**
     * Scopes
     */
    public function scopePendentes($query)
    {
        return $query->where('status', 'pendente')
                    ->where('expires_at', '>', now());
    }

    public function scopeExpiradas($query)
    {
        return $query->where('status', 'pendente')
                    ->where('expires_at', '<=', now());
    }

    public function scopeAutorizadas($query)
    {
        return $query->where('status', 'autorizada');
    }

    public function scopeCanceladas($query)
    {
        return $query->where('status', 'cancelada');
    }

    /**
     * Métodos de verificação
     */
    public function estaExpirada(): bool
    {
        return $this->status === 'pendente' && $this->expires_at <= now();
    }

    public function podeSerAutorizada(): bool
    {
        return $this->status === 'pendente' && !$this->estaExpirada();
    }

    public function tempoRestante(): int
    {
        if ($this->estaExpirada()) {
            return 0;
        }

        return max(0, $this->expires_at->diffInSeconds(now()));
    }

    /**
     * Mutators
     */
    public function setPinAttribute($value): void
    {
        $this->attributes['pin'] = strtoupper($value);
    }

    /**
     * Métodos de ação
     */
    public function autorizar(): bool
    {
        if (!$this->podeSerAutorizada()) {
            return false;
        }

        $this->update([
            'status' => 'autorizada',
            'authorized_at' => now(),
        ]);

        return true;
    }

    public function expirar(): bool
    {
        if ($this->status !== 'pendente') {
            return false;
        }

        $this->update(['status' => 'expirada']);

        return true;
    }

    public function cancelar(): bool
    {
        if ($this->status !== 'pendente') {
            return false;
        }

        $this->update(['status' => 'cancelada']);

        return true;
    }
}
