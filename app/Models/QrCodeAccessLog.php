<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QrCodeAccessLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'qr_code_id',
        'ip_address',
        'user_agent',
        'referer',
        'request_data',
    ];

    protected $casts = [
        'request_data' => 'array',
    ];

    /**
     * Relacionamento com o QrCode
     */
    public function qrCode(): BelongsTo
    {
        return $this->belongsTo(QrCode::class);
    }
}
