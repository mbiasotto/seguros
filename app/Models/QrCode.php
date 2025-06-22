<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'link',
        'type',
        'is_active',
        'max_establishments',
        'created_by'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Relacionamento com estabelecimentos
     */
    public function establishments()
    {
        return $this->belongsToMany(Estabelecimento::class, 'establishment_qr_codes');
    }

    /**
     * Relacionamento com logs de acesso
     */
    public function accessLogs()
    {
        return $this->hasMany(QrCodeAccessLog::class);
    }

    /**
     * Relacionamento com criador
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Verificar se está disponível para um estabelecimento
     */
    public function isAvailableFor($establishment = null)
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->max_establishments <= 0) {
            return true; // Sem limite
        }

        $currentCount = $this->establishments()->count();

        if ($establishment) {
            // Se o estabelecimento já tem este QR Code, considerar como disponível
            if ($this->establishments()->where('estabelecimentos.id', $establishment->id)->exists()) {
                return true;
            }
        }

        return $currentCount < $this->max_establishments;
    }

    /**
     * Escopo para QR Codes ativos
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Escopo para QR Codes disponíveis
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_active', true)
                    ->where(function($q) {
                        $q->where('max_establishments', 0)
                          ->orWhereRaw('(SELECT COUNT(*) FROM establishment_qr_codes WHERE qr_code_id = qr_codes.id) < max_establishments');
                    });
    }
}
