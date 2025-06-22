<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
        ];
    }

    /**
     * Usuários criados por este admin
     */
    public function usuariosCriados()
    {
        return $this->hasMany(Usuario::class, 'criado_por_admin_id');
    }

    /**
     * Estabelecimentos criados por este admin
     */
    public function estabelecimentosCriados()
    {
        return $this->hasMany(Estabelecimento::class, 'criado_por_admin_id');
    }

    /**
     * Retorna o último acesso do usuário (placeholder)
     */
    public function lastAccess()
    {
        // Por enquanto retorna null - implementar logs de acesso se necessário
        return null;
    }
}
