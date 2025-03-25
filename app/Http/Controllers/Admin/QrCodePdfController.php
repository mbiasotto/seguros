<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade\Pdf;

class QrCodePdfController extends Controller
{
    /**
     * Generate a PDF with all QR codes organized in a grid layout
     *
     * @return \Illuminate\Http\Response
     */
    public function generatePdf()
    {
        // Directory where QR codes are stored
        $qrCodesDir = public_path('qr_codes');

        // Get all QR code files
        $qrCodeFiles = File::files($qrCodesDir);

        // Sort files by QR code ID
        usort($qrCodeFiles, function ($a, $b) {
            $idA = (int) preg_replace('/[^0-9]/', '', $a->getFilename());
            $idB = (int) preg_replace('/[^0-9]/', '', $b->getFilename());
            return $idA - $idB;
        });

        // Pass data to the view
        $data = [
            'qrCodeFiles' => $qrCodeFiles,
        ];

        // Generate PDF with A4 size
        $pdf = PDF::loadView('admin.qr_codes.pdf', $data);
        $pdf->setPaper('a4');

        // Download the PDF
        return $pdf->download('qr_codes.pdf');
    }
}