<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QrCode;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode as QrCodeGenerator;
use Illuminate\Support\Str;

class QrCodeController extends Controller
{
    public function index()
    {
        $qrCodes = QrCode::paginate(10);
        return view('admin.qr_codes.index', compact('qrCodes'));
    }

    public function create()
    {
        return view('admin.qr_codes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'link' => 'required|string',
            'description' => 'nullable|string',
            'active' => 'boolean'
        ]);

        QrCode::create($validated);

        return redirect()->route('admin.qr-codes.index')
            ->with('success', 'QR Code criado com sucesso!');
    }

    public function show(QrCode $qrCode)
    {
        // Generate QR code with logo
        $qrCodeImage = QrCodeGenerator::format('png')
            ->size(300)
            ->errorCorrection('H')
            ->merge(public_path('img/logo.png'), 0.3, true)
            ->generate($qrCode->qr_code_url);

        // Create a larger image to accommodate the QR code and the ID text below the logo
        $qrSize = 300; // Original QR code size
        $padding = 30; // Extra space for the ID text
        
        // Create a new image with extra space at the bottom
        $newImage = imagecreatetruecolor($qrSize, $qrSize + $padding);
        $white = imagecolorallocate($newImage, 255, 255, 255);
        imagefill($newImage, 0, 0, $white);
        
        // Add QR Code to the new image
        $image = imagecreatefromstring($qrCodeImage);
        imagecopy($newImage, $image, 0, 0, 0, 0, $qrSize, $qrSize);
        imagedestroy($image);
        
        // Add QR Code ID to the image below the logo
        $black = imagecolorallocate($newImage, 0, 0, 0);
        $fontSize = 5;
        $text = "ID: " . $qrCode->id;
        $textWidth = imagefontwidth($fontSize) * strlen($text);
        $x = ($qrSize - $textWidth) / 2;
        // Position the text below the QR code
        $y = $qrSize + 10; // 10 pixels below the QR code
        imagestring($newImage, $fontSize, $x, $y, $text, $black);
        
        ob_start();
        imagepng($newImage);
        $qrCodeImage = ob_get_contents();
        ob_end_clean();
        imagedestroy($newImage);

        return view('admin.qr_codes.show', compact('qrCode', 'qrCodeImage'));
    }

    public function edit(QrCode $qrCode)
    {
        return view('admin.qr_codes.edit', compact('qrCode'));
    }

    public function update(Request $request, QrCode $qrCode)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'link' => 'required|string',
            'description' => 'nullable|string',
            'active' => 'boolean'
        ]);

        $qrCode->update($validated);

        return redirect()->route('admin.qr-codes.index')
            ->with('success', 'QR Code atualizado com sucesso!');
    }

    public function destroy(QrCode $qrCode)
    {
        $qrCode->delete();

        return redirect()->route('admin.qr-codes.index')
            ->with('success', 'QR Code excluído com sucesso!');
    }

    public function download(QrCode $qrCode)
    {
        $qrCodeImage = QrCodeGenerator::format('png')
            ->size(300)
            ->errorCorrection('H')
            ->merge(public_path('img/logo.png'), 0.3, true)
            ->generate($qrCode->qr_code_url);

        // Create a larger image to accommodate the QR code and the ID text below the logo
        $qrSize = 300; // Original QR code size
        $padding = 30; // Extra space for the ID text
        
        // Create a new image with extra space at the bottom
        $newImage = imagecreatetruecolor($qrSize, $qrSize + $padding);
        $white = imagecolorallocate($newImage, 255, 255, 255);
        imagefill($newImage, 0, 0, $white);
        
        // Add QR Code to the new image
        $image = imagecreatefromstring($qrCodeImage);
        imagecopy($newImage, $image, 0, 0, 0, 0, $qrSize, $qrSize);
        imagedestroy($image);
        
        // Add QR Code ID to the image below the logo
        $black = imagecolorallocate($newImage, 0, 0, 0);
        $fontSize = 5;
        $text = "ID: " . $qrCode->id;
        $textWidth = imagefontwidth($fontSize) * strlen($text);
        $x = ($qrSize - $textWidth) / 2;
        // Position the text below the QR code
        $y = $qrSize + 10; // 10 pixels below the QR code
        imagestring($newImage, $fontSize, $x, $y, $text, $black);
        
        ob_start();
        imagepng($newImage);
        $qrCodeImage = ob_get_contents();
        ob_end_clean();
        imagedestroy($newImage);

        $filename = Str::slug($qrCode->title ?: 'qr-code') . '.png';

        return response($qrCodeImage)
            ->header('Content-Type', 'image/png')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}