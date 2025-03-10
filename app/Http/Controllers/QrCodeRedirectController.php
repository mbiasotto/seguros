<?php

namespace App\Http\Controllers;

use App\Models\QrCode;
use Illuminate\Http\Request;

class QrCodeRedirectController extends Controller
{
    /**
     * Redirect to the URL associated with the QR code
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
        
        // Ensure the link has a proper URL scheme
        $link = $qrCode->link;
        if (!preg_match("~^(?:f|ht)tps?://~i", $link)) {
            $link = "http://" . $link;
        }
        
        return redirect($link);
    }
}