<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'clientes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'cpf',
        'nome',
        'email',
        'telefone',
        'password',
        'conta_cpfl',
        'numero_cartao',
        'validade_cartao',
        'limite_total',
        'limite_disponivel',
        'limite_credito_manual',
        'limite_credito_sugerido',
        'motivo_limite_manual',
        'score_atual',
        'data_ultima_consulta_score',
        'limite_aprovado_por',
        'data_aprovacao_limite',
        'status',
        'endereco',
        'cidade',
        'estado',
        'cep',
        'criado_por_admin_id',
        'meses_gratuitos',
        'valor_mensalidade',
        'data_fim_gratuidade',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'validade_cartao' => 'date',
            'limite_total' => 'decimal:2',
            'limite_disponivel' => 'decimal:2',
            'limite_credito_manual' => 'decimal:2',
            'limite_credito_sugerido' => 'decimal:2',
            'data_ultima_consulta_score' => 'datetime',
            'data_aprovacao_limite' => 'datetime',
            'valor_mensalidade' => 'decimal:2',
            'data_fim_gratuidade' => 'date',
        ];
    }

    /**
     * Relacionamento com o admin que criou o usuário
     */
    public function criadoPorAdmin()
    {
        return $this->belongsTo(User::class, 'criado_por_admin_id');
    }

    /**
     * Verifica se o usuário está ativo
     */
    public function isAtivo(): bool
    {
        return $this->status === 'ativo';
    }

    /**
     * Verifica se o usuário está pendente
     */
    public function isPendente(): bool
    {
        return $this->status === 'pendente';
    }

    /**
     * Verifica se o usuário está bloqueado
     */
    public function isBloqueado(): bool
    {
        return $this->status === 'bloqueado';
    }

    /**
     * Ativar usuário
     */
    public function ativar(): void
    {
        $this->update(['status' => 'ativo']);
    }

    /**
     * Bloquear usuário
     */
    public function bloquear(): void
    {
        $this->update(['status' => 'bloqueado']);
    }

    /**
     * Formatar CPF
     */
    public function getCpfFormatadoAttribute(): string
    {
        return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $this->cpf);
    }

    /**
     * Formatar telefone
     */
    public function getTelefoneFormatadoAttribute(): string
    {
        return preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $this->telefone);
    }

    /**
     * Formatar CEP
     */
    public function getCepFormatadoAttribute(): string
    {
        return preg_replace('/(\d{5})(\d{3})/', '$1-$2', $this->cep);
    }

    /**
     * Relacionamento com Saldos
     */
    public function saldos()
    {
        return $this->hasMany(Saldo::class);
    }

    /**
     * Relacionamento com Recargas Pré-pago
     */
    public function recargas()
    {
        return $this->hasMany(RecargaPrepago::class);
    }

    /**
     * Obter saldo total disponível (soma de todos os saldos ativos)
     */
    public function getSaldoTotalAttribute(): float
    {
        return $this->saldos()
            ->ativos()
            ->comSaldo()
            ->sum('valor_disponivel');
    }

    /**
     * Obter saldo pré-pago disponível
     */
    public function getSaldoPrePagoAttribute(): float
    {
        return $this->saldos()
            ->ativos()
            ->tipo(Saldo::TIPO_PRE_PAGO)
            ->comSaldo()
            ->sum('valor_disponivel');
    }

    /**
     * Obter saldo de mensalidade disponível
     */
    public function getSaldoMensalidadeAttribute(): float
    {
        return $this->saldos()
            ->ativos()
            ->tipo(Saldo::TIPO_MENSALIDADE)
            ->comSaldo()
            ->sum('valor_disponivel');
    }

    /**
     * Obter saldo de limite consignado disponível
     */
    public function getSaldoLimiteConsignadoAttribute(): float
    {
        return $this->saldos()
            ->ativos()
            ->tipo(Saldo::TIPO_LIMITE_CONSIGNADO)
            ->comSaldo()
            ->sum('valor_disponivel');
    }

    /**
     * Verificar se tem saldo disponível suficiente
     */
    public function temSaldoDisponivel(float $valor): bool
    {
        return $this->saldo_total >= $valor;
    }

    /**
     * Verificar se está no período de gratuidade
     */
    public function estaEmPeriodoGratuito(): bool
    {
        if ($this->meses_gratuitos <= 0) {
            return false;
        }

        if (!$this->data_fim_gratuidade) {
            return false;
        }

        return $this->data_fim_gratuidade->isFuture();
    }

    /**
     * Verificar se a gratuidade expirou
     */
    public function gratuidadeExpirou(): bool
    {
        if ($this->meses_gratuitos <= 0) {
            return false;
        }

        if (!$this->data_fim_gratuidade) {
            return false;
        }

        return $this->data_fim_gratuidade->isPast();
    }

    /**
     * Definir período de gratuidade
     */
    public function definirGratuidade(int $meses, float $valorMensalidade): void
    {
        $this->meses_gratuitos = $meses;
        $this->valor_mensalidade = $valorMensalidade;
        $this->data_fim_gratuidade = now()->addMonths($meses);
        $this->save();
    }

    /**
     * Relacionamento com Contrato
     */
    public function contrato()
    {
        return $this->hasOne(Contrato::class);
    }

    /**
     * Relacionamento com o admin que aprovou o limite
     */
    public function adminLimiteAprovadoPor()
    {
        return $this->belongsTo(User::class, 'limite_aprovado_por');
    }

    /**
     * Obter limite disponível (manual ou sugerido)
     */
    public function getLimiteDisponivelAttribute(): float
    {
        return $this->limite_credito_manual ?? $this->limite_credito_sugerido ?? 0;
    }

    /**
     * Verificar se tem contrato ativo
     */
    public function temContratoAtivo(): bool
    {
        return $this->contrato && $this->contrato->estaAtivo();
    }

    /**
     * Formatar número do cartão
     */
    public function getCartaoFormatadoAttribute(): string
    {
        if (!$this->numero_cartao) {
            return '';
        }

        return preg_replace('/(\d{4})(\d{4})(\d{4})(\d{4})/', '$1 $2 $3 $4', $this->numero_cartao);
    }

    /**
     * Verificar se o score precisa ser atualizado
     */
    public function precisaAtualizarScore(): bool
    {
        if (!$this->data_ultima_consulta_score) {
            return true;
        }

        $prazoRevisao = Configuracao::prazoRevisaoScoreDias();
        return $this->data_ultima_consulta_score->diffInDays(now()) >= $prazoRevisao;
    }

    /**
     * Verificar se tem limite definido
     */
    public function temLimiteDefinido(): bool
    {
        return $this->limite_credito_manual !== null || $this->limite_credito_sugerido !== null;
    }

    /**
     * Scope para usuários com contrato ativo
     */
    public function scopeComContratoAtivo($query)
    {
        return $query->whereHas('contrato', function ($q) {
            $q->where('status', Contrato::STATUS_ATIVO);
        });
    }

    /**
     * Scope para usuários que precisam de revisão de score
     */
    public function scopePrecisaRevisaoScore($query)
    {
        $prazoRevisao = Configuracao::prazoRevisaoScoreDias();
        $dataLimite = now()->subDays($prazoRevisao);

        return $query->where(function ($q) use ($dataLimite) {
            $q->whereNull('data_ultima_consulta_score')
              ->orWhere('data_ultima_consulta_score', '<=', $dataLimite);
        });
    }
}
