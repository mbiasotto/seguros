<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VendorAccessLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'ip_address',
        'user_agent'
    ];

    /**
     * Relacionamento com o vendedor
     */
    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }
}