<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAccessLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ip_address',
        'user_agent'
    ];

    /**
     * Relacionamento com o usuário administrador
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}