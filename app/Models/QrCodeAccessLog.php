<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class QrCodeAccessLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'qr_code_id',
        'establishment_id',
        'ip_address',
        'user_agent',
        'accessed_at',
        'referrer',
        'country',
        'city',
        'device_type'
    ];

    protected $casts = [
        'accessed_at' => 'datetime',
    ];

    /**
     * Relacionamento com QR Code
     */
    public function qrCode()
    {
        return $this->belongsTo(QrCode::class);
    }

    /**
     * Relacionamento com Estabelecimento
     */
    public function establishment()
    {
        return $this->belongsTo(Estabelecimento::class);
    }

    /**
     * Registrar um novo acesso
     */
    public static function register($qrCodeId, $establishmentId = null, $request = null)
    {
        return self::create([
            'qr_code_id' => $qrCodeId,
            'establishment_id' => $establishmentId,
            'ip_address' => $request ? $request->ip() : null,
            'user_agent' => $request ? $request->userAgent() : null,
            'accessed_at' => Carbon::now(),
            'referrer' => $request ? $request->header('referer') : null,
            'device_type' => self::detectDeviceType($request ? $request->userAgent() : null),
        ]);
    }

    /**
     * Detectar tipo de dispositivo baseado no user agent
     */
    private static function detectDeviceType($userAgent)
    {
        if (!$userAgent) {
            return 'unknown';
        }

        if (preg_match('/mobile|android|iphone|ipad|phone/i', $userAgent)) {
            return 'mobile';
        }

        if (preg_match('/tablet|ipad/i', $userAgent)) {
            return 'tablet';
        }

        return 'desktop';
    }

    /**
     * Escopo para acessos de hoje
     */
    public function scopeToday($query)
    {
        return $query->whereDate('accessed_at', Carbon::today());
    }

    /**
     * Escopo para acessos desta semana
     */
    public function scopeThisWeek($query)
    {
        return $query->whereBetween('accessed_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ]);
    }

    /**
     * Escopo para acessos deste mês
     */
    public function scopeThisMonth($query)
    {
        return $query->whereMonth('accessed_at', Carbon::now()->month)
                    ->whereYear('accessed_at', Carbon::now()->year);
    }
}
