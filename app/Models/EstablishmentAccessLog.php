<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EstablishmentAccessLog extends Model
{
    protected $fillable = [
        'establishment_id',
        'ip_address',
        'user_agent'
    ];

    /**
     * Relacionamento com o estabelecimento
     */
    public function establishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class);
    }
}
