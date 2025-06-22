<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Estabelecimento extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'estabelecimentos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'cnpj',
        'razao_social',
        'nome_fantasia',
        'email',
        'telefone',
        'password',
        'endereco',
        'numero',
        'bairro',
        'cidade',
        'estado',
        'cep',
        'categoria_id',
        'taxa_multiplic',
        'taxa_estabelecimento',
        'status',
        'criado_por_admin_id',
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
            'taxa_multiplic' => 'decimal:2',
            'taxa_estabelecimento' => 'decimal:2',
        ];
    }

    /**
     * Relacionamento com o admin que criou o estabelecimento
     */
    public function criadoPorAdmin()
    {
        return $this->belongsTo(User::class, 'criado_por_admin_id');
    }

    /**
     * Relacionamento com a categoria
     */
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    /**
     * Verifica se o estabelecimento está ativo
     */
    public function isAtivo(): bool
    {
        return $this->status === 'ativo';
    }

    /**
     * Verifica se o estabelecimento está pendente
     */
    public function isPendente(): bool
    {
        return $this->status === 'pendente';
    }

    /**
     * Verifica se o estabelecimento está bloqueado
     */
    public function isBloqueado(): bool
    {
        return $this->status === 'bloqueado';
    }

    /**
     * Ativar estabelecimento
     */
    public function ativar(): void
    {
        $this->update(['status' => 'ativo']);
    }

    /**
     * Bloquear estabelecimento
     */
    public function bloquear(): void
    {
        $this->update(['status' => 'bloqueado']);
    }

    /**
     * Formatar CNPJ
     */
    public function getCnpjFormatadoAttribute(): string
    {
        return preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $this->cnpj);
    }

    /**
     * Formatar telefone
     */
    public function getTelefoneFormatadoAttribute(): string
    {
        return preg_replace('/(\d{2})(\d{4,5})(\d{4})/', '($1) $2-$3', $this->telefone);
    }

    /**
     * Formatar CEP
     */
    public function getCepFormatadoAttribute(): string
    {
        return preg_replace('/(\d{5})(\d{3})/', '$1-$2', $this->cep);
    }

    /**
     * Endereço completo formatado
     */
    public function getEnderecoCompletoAttribute(): string
    {
        return sprintf(
            '%s, %s - %s - %s/%s - CEP: %s',
            $this->endereco,
            $this->numero,
            $this->bairro,
            $this->cidade,
            $this->estado,
            $this->cep_formatado
        );
    }

    /**
     * Nome da categoria
     */
    public function getNomeCategoriaAttribute(): ?string
    {
        return $this->categoria?->nome;
    }

    /**
     * Valida se a soma das taxas é 100%
     */
    public function taxasValidadas(): bool
    {
        return ($this->taxa_multiplic + $this->taxa_estabelecimento) == 100;
    }
}
