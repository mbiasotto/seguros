<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use App\Notifications\EstablishmentResetPasswordNotification;

class Establishment extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'vendor_id',
        'category_id',
        'nome',
        'endereco',
        'numero',
        'cidade',
        'estado',
        'cep',
        'telefone',
        'email',
        'password',
        'descricao',
        'ativo',
        'name',
        'cnpj',
        'cpf',
        'tipo_documento',
        'description',
        'address',
        'logo',
        'image',
    ];

    protected $casts = [
        'ativo' => 'boolean',
        'email_verified_at' => 'datetime',
        'last_access_at' => 'datetime',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    /**
     * Relacionamento com a categoria
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relacionamento com o onboarding do estabelecimento
     */
    public function onboarding(): HasOne
    {
        return $this->hasOne(EstablishmentOnboarding::class);
    }

    /**
     * Relacionamento com QR codes
     */
    public function qrCodes(): BelongsToMany
    {
        return $this->belongsToMany(QrCode::class, 'establishment_qr_code')
                    ->withPivot('notes')
                    ->withTimestamps();
    }

    /**
     * Relacionamento com os logs de acesso
     */
    public function accessLogs(): HasMany
    {
        return $this->hasMany(EstablishmentAccessLog::class);
    }

    /**
     * Obtém o último log de acesso do estabelecimento
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
        $this->notify(new EstablishmentResetPasswordNotification($token));
    }
}
