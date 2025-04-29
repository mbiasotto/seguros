<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Collection;

class QrCodePdfController extends Controller
{
    /**
     * Generate a PDF with QR codes within a specified ID range.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function generatePdf(Request $request)
    {
        // Validate the incoming request (optional but recommended)
        $validated = $request->validate([
            'start' => 'nullable|integer|min:1',
            'end' => 'nullable|integer|min:1|gte:start', // gte:start ensures end >= start if both are present
        ]);

        $startId = $validated['start'] ?? null;
        $endId = $validated['end'] ?? null;

        // Directory where QR codes are stored
        $qrCodesDir = public_path('qr_codes');

        // Get all QR code files
        $allQrCodeFiles = File::files($qrCodesDir);

        // Filter files based on the ID range provided
        $qrCodeFiles = collect($allQrCodeFiles)->filter(function ($file) use ($startId, $endId) {
            $filename = $file->getFilename();
            // Extract numeric ID from filename (e.g., qrcode_123.png -> 123)
            if (preg_match('/\d+/', $filename, $matches)) {
                $id = (int) $matches[0];
                // Include if no range is specified OR if ID is within the range
                if (is_null($startId) && is_null($endId)) {
                    return true; // No range specified, include all
                } elseif (!is_null($startId) && !is_null($endId)) {
                    return $id >= $startId && $id <= $endId; // Both start and end specified
                } elseif (!is_null($startId)) {
                    return $id >= $startId; // Only start specified
                } elseif (!is_null($endId)) {
                    return $id <= $endId; // Only end specified
                }
            }
            return false; // Exclude if filename doesn't contain a numeric ID or doesn't match range
        })->sortBy(function ($file) {
            // Sort by the extracted numeric ID
             if (preg_match('/\d+/', $file->getFilename(), $matches)) {
                return (int) $matches[0];
            }
            return PHP_INT_MAX; // Put files without numbers at the end
        })->values()->all(); // Convert back to a simple array

        // Pass filtered and sorted data to the view
        $data = [
            'qrCodeFiles' => $qrCodeFiles,
            'startId' => $startId,
            'endId' => $endId
        ];

        // Generate PDF with A4 size
        $pdf = PDF::loadView('admin.qr_codes.pdf', $data);
        $pdf->setPaper('a4');

        // Create a filename reflecting the range
        $filename = 'qr_codes';
        if ($startId && $endId) {
            $filename .= "_{$startId}-{$endId}";
        } elseif ($startId) {
            $filename .= "_from_{$startId}";
        } elseif ($endId) {
            $filename .= "_up_to_{$endId}";
        }
        $filename .= '.pdf';

        // Download the PDF
        return $pdf->download($filename);
    }
}
