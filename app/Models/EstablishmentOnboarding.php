<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use App\Models\User;

class EstablishmentOnboarding extends Model
{
    protected $fillable = [
        'establishment_id',
        'token',
        'document_path',
        'document_approved',
        'document_approved_at',
        'approved_by_user_id',
        'approval_notes',
        'contract_accepted',
        'contract_accepted_at',
        'ip_address',
        'completed',
        'completed_at',
        'expires_at'
    ];

    protected $casts = [
        'contract_accepted' => 'boolean',
        'completed' => 'boolean',
        'document_approved' => 'boolean',
        'contract_accepted_at' => 'datetime',
        'completed_at' => 'datetime',
        'document_approved_at' => 'datetime',
        'expires_at' => 'datetime'
    ];

    /**
     * Relacionamento com o estabelecimento
     */
    public function establishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class);
    }

    /**
     * Relacionamento com o usuário que aprovou o documento
     */
    public function approvedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by_user_id');
    }

    /**
     * Gera um token único para o onboarding
     */
    public static function generateUniqueToken(): string
    {
        $token = Str::random(64);

        // Verifica se o token já existe
        while (self::where('token', $token)->exists()) {
            $token = Str::random(64);
        }

        return $token;
    }

    /**
     * Verifica se o onboarding está expirado
     */
    public function isExpired(): bool
    {
        // Se não houver data de expiração definida, o token não expira
        if (!$this->expires_at) {
            return false;
        }

        return now()->gt($this->expires_at);
    }

    /**
     * Verifica se o onboarding está completo
     */
    public function isCompleted(): bool
    {
        return $this->completed;
    }

    /**
     * Marca o onboarding como completo
     */
    public function markAsCompleted(): void
    {
        $this->update([
            'completed' => true,
            'completed_at' => now()
        ]);
    }

    /**
     * Verifica se o documento foi aprovado
     */
    public function isDocumentApproved(): bool
    {
        return $this->document_approved;
    }

    /**
     * Aprova o documento do estabelecimento
     */
    public function approveDocument(int $userId, ?string $notes = null): void
    {
        $this->update([
            'document_approved' => true,
            'document_approved_at' => now(),
            'approved_by_user_id' => $userId,
            'approval_notes' => $notes
        ]);
    }

    /**
     * Rejeita o documento do estabelecimento
     */
    public function rejectDocument(int $userId, ?string $notes = null): void
    {
        $this->update([
            'document_approved' => false,
            'document_approved_at' => now(),
            'approved_by_user_id' => $userId,
            'approval_notes' => $notes
        ]);
    }
}
