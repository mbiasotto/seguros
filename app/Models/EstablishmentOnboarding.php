<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class EstablishmentOnboarding extends Model
{
    use HasFactory;

    protected $fillable = [
        'establishment_id',
        'token',
        'contract_accepted',
        'contract_accepted_at',
        'contract_version',
        'acceptance_details',
        'document_path',
        'document_approved',
        'document_approved_at',
        'document_approved_by',
        'approval_notes',
        'user_ip',
        'user_agent',
        'completed_at'
    ];

    protected $casts = [
        'contract_accepted' => 'boolean',
        'contract_accepted_at' => 'datetime',
        'document_approved' => 'boolean',
        'document_approved_at' => 'datetime',
        'acceptance_details' => 'json',
        'completed_at' => 'datetime'
    ];

    /**
     * Relacionamento com estabelecimento
     */
    public function establishment()
    {
        return $this->belongsTo(Estabelecimento::class);
    }

    /**
     * Relacionamento com o admin que aprovou o documento
     */
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'document_approved_by');
    }

    /**
     * Gerar token único
     */
    public static function generateToken()
    {
        do {
            $token = Str::random(64);
        } while (self::where('token', $token)->exists());

        return $token;
    }

    /**
     * Verificar se o onboarding está completo
     */
    public function isCompleted()
    {
        return $this->contract_accepted &&
               $this->contract_accepted_at &&
               (!$this->document_path || ($this->document_approved && $this->document_approved_at));
    }

    /**
     * Marcar como aceito
     */
    public function markAsAccepted(array $acceptanceDetails = [])
    {
        $this->update([
            'contract_accepted' => true,
            'contract_accepted_at' => Carbon::now(),
            'acceptance_details' => $acceptanceDetails,
            'completed_at' => Carbon::now()
        ]);

        return $this;
    }

    /**
     * Aprovar documento
     */
    public function approveDocument($adminId, $notes = null)
    {
        $this->update([
            'document_approved' => true,
            'document_approved_at' => Carbon::now(),
            'document_approved_by' => $adminId,
            'approval_notes' => $notes
        ]);

        return $this;
    }

    /**
     * Rejeitar documento
     */
    public function rejectDocument($adminId, $notes = null)
    {
        $this->update([
            'document_approved' => false,
            'document_approved_at' => Carbon::now(),
            'document_approved_by' => $adminId,
            'approval_notes' => $notes
        ]);

        return $this;
    }

    /**
     * Escopo para documentos pendentes
     */
    public function scopePendingDocuments($query)
    {
        return $query->whereNotNull('document_path')
                    ->where('document_approved', false)
                    ->whereNull('document_approved_at');
    }

    /**
     * Escopo para onboardings completos
     */
    public function scopeCompleted($query)
    {
        return $query->where('contract_accepted', true)
                    ->whereNotNull('contract_accepted_at');
    }

    /**
     * Escopo para onboardings pendentes
     */
    public function scopePending($query)
    {
        return $query->where('contract_accepted', false)
                    ->orWhereNull('contract_accepted_at');
    }
}
