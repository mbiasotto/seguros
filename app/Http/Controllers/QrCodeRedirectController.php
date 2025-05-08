<?php

namespace App\Http\Controllers;

use App\Models\QrCode;
use App\Models\QrCodeAccessLog;
use Illuminate\Http\Request;

class QrCodeRedirectController extends Controller
{
    /**
     * Redirect to WhatsApp with a pre-defined message including the QR code ID
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirect(Request $request, $id)
    {
        $qrCode = QrCode::findOrFail($id);

        // Only redirect if the QR code is active
        if (!$qrCode->active) {
            abort(404);
        }

        // Registrar o acesso ao QR code
        $this->logAccess($request, $qrCode);

        // WhatsApp number
        $phoneNumber = "5515996605233";//"5515998260188";

        // Pre-defined message with the QR code ID as discount code
        $message = "Olá! Gostaria de fazer uma cotação de seguro e aproveitar meu desconto exclusivo. Meu código promocional é #{$id}. Poderia me ajudar?";

        // Create WhatsApp URL
        $whatsappUrl = "https://api.whatsapp.com/send?phone={$phoneNumber}&text=" . urlencode($message);

        return redirect($whatsappUrl);
    }

    /**
     * Registra o acesso ao QR Code
     *
     * @param Request $request
     * @param QrCode $qrCode
     * @return void
     */
    private function logAccess(Request $request, QrCode $qrCode): void
    {
        QrCodeAccessLog::create([
            'qr_code_id' => $qrCode->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'referer' => $request->header('referer'),
            'request_data' => [
                'query' => $request->query(),
                'headers' => $request->header(),
                'method' => $request->method(),
                'path' => $request->path(),
                'url' => $request->url(),
                'date' => now()->toIso8601String(),
            ],
        ]);
    }
}
