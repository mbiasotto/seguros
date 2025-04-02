<?php

namespace App\Http\Controllers;

use App\Models\QrCode;
use Illuminate\Http\Request;

class QrCodeRedirectController extends Controller
{
    /**
     * Redirect to WhatsApp with a pre-defined message including the QR code ID
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirect($id)
    {
        $qrCode = QrCode::findOrFail($id);

        // Only redirect if the QR code is active
        if (!$qrCode->active) {
            abort(404);
        }

        // WhatsApp number
        $phoneNumber = "5515998260188";

        // Pre-defined message with the QR code ID as discount code
        $message = "Olá! Gostaria de fazer uma cotação de seguro e aproveitar meu desconto exclusivo. Meu código promocional é #{$id}. Poderia me ajudar?";

        // Create WhatsApp URL
        $whatsappUrl = "https://api.whatsapp.com/send?phone={$phoneNumber}&text=" . urlencode($message);

        return redirect($whatsappUrl);
    }
}