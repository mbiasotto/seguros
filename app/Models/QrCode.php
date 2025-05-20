<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QrCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'link',
        'description',
        'active'
    ];

    protected $casts = [
        'active' => 'boolean'
    ];

    public function getQrCodeUrlAttribute(): string
    {
        return route('qr-code.redirect', $this->id);
    }

    /**
     * Relacionamento com estabelecimentos
     */
    public function establishments(): BelongsToMany
    {
        return $this->belongsToMany(Establishment::class, 'establishment_qr_code')
                    ->withPivot('notes')
                    ->withTimestamps();
    }

    /**
     * Verifica se o QR code está disponível (não vinculado a nenhum estabelecimento)
     * ou se já está vinculado ao estabelecimento especificado
     */
    public function isAvailableFor(?Establishment $establishment = null): bool
    {
        if (!$establishment) {
            return $this->establishments()->count() === 0;
        }

        return $this->establishments()->count() === 0 ||
               $this->establishments()->where('establishment_id', $establishment->id)->exists();
    }

    /**
     * Relacionamento com os logs de acesso
     */
    public function accessLogs(): HasMany
    {
        return $this->hasMany(QrCodeAccessLog::class);
    }
}
