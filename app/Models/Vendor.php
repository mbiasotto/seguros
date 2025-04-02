<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use App\Notifications\VendorResetPasswordNotification;

class Vendor extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nome',
        'email',
        'password',
        'telefone',
        'cidade',
        'estado',
        'observacoes',
        'ativo'
    ];

    protected $casts = [
        'ativo' => 'boolean'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function establishments(): HasMany
    {
        return $this->hasMany(Establishment::class);
    }

    /**
     * Relacionamento com os logs de acesso
     */
    public function accessLogs(): HasMany
    {
        return $this->hasMany(VendorAccessLog::class);
    }

    /**
     * Obtém o último log de acesso do vendedor
     */
    public function lastAccess()
    {
        return $this->accessLogs()->latest()->first();
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new VendorResetPasswordNotification($token));
    }
}
