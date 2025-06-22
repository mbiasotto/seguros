<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Cliente extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'clientes';

    protected $fillable = [
        'nome',
        'email',
        'cpf',
        'telefone',
        'password',
        'limite_total',
        'limite_disponivel',
        'status',
        'criado_por_admin_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'limite_total' => 'decimal:2',
        'limite_disponivel' => 'decimal:2',
    ];

    /**
     * Admin que criou este cliente
     */
    public function criadoPorAdmin()
    {
        return $this->belongsTo(User::class, 'criado_por_admin_id');
    }

    /**
     * Estabelecimentos deste cliente
     */
    public function estabelecimentos()
    {
        return $this->hasMany(Estabelecimento::class, 'usuario_id');
    }

    // Recargas removidas - implementar se necessário

    /**
     * Scope para clientes ativos
     */
    public function scopeAtivos($query)
    {
        return $query->where('status', 'ativo');
    }

    /**
     * Scope para clientes bloqueados
     */
    public function scopeBloqueados($query)
    {
        return $query->where('status', 'bloqueado');
    }

    /**
     * Scope para clientes pendentes
     */
    public function scopePendentes($query)
    {
        return $query->where('status', 'pendente');
    }
}
