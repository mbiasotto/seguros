<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
}