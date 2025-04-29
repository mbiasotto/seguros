<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QrCode;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode as QrCodeGenerator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class QrCodeController extends Controller
{
    public function index(Request $request)
    {
        // Aumentando o número de itens por página para 20
        // e adicionando filtros para melhorar a usabilidade
        $query = QrCode::query();

        // Filtro por status (ativo/inativo)
        if ($request->has('status')) {
            if ($request->status === 'active') {
                $query->where('active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('active', false);
            }
        }

        // Busca por título, ID ou link
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%")
                  ->orWhere('link', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Ordenação
        $orderBy = $request->order_by ?? 'id';
        $orderDir = $request->order_dir ?? 'asc';
        $query->orderBy($orderBy, $orderDir);

        // Aumentando para 25 itens por página para melhor visualização
        $qrCodes = $query->paginate(25)->withQueryString();
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

    /**
     * Gera QR Codes em lote com base em um intervalo de IDs.
     *
     * @param int $startId
     * @param int $endId
     * @return \Illuminate\Http\Response
     */
    public function generateBatch(int $startId, int $endId)
    {
        // Diretório onde os QR codes serão salvos
        $outputDir = public_path('qr_codes'); // Usar public_path

        // Criar o diretório se não existir
        if (!File::isDirectory($outputDir)) {
            File::makeDirectory($outputDir, 0755, true, true);
        }

        // Definir o domínio base para os QR codes (pode vir de .env ou config)
        $baseUrl = config('app.url', 'https://seguraessa.app'); // Usar config('app.url') como padrão

        $generatedFiles = [];

        // Validar se startId é menor ou igual a endId
        if ($startId > $endId) {
            return response("O ID inicial ({$startId}) não pode ser maior que o ID final ({$endId}).", 400);
        }

        // Limitar a geração para evitar sobrecarga (opcional, mas recomendado)
        $limit = 500; // Exemplo: limitar a 500 QRs por vez
        if (($endId - $startId + 1) > $limit) {
             return response("A geração está limitada a {$limit} QR codes por vez. Intervalo solicitado: " . ($endId - $startId + 1), 400);
        }


        for ($id = $startId; $id <= $endId; $id++) {
            // URL para o QR code
            $url = rtrim($baseUrl, '/') . '/qr-code/' . $id;

            // Nome do arquivo
            $filename = $outputDir . '/qr_code_' . $id . '.png';

            // Gerar o QR code com tamanho 750x750 pixels e margem zero
            $qrCodeImage = QrCodeGenerator::format('png')
                ->size(750)
                ->margin(0) // Margem zero
                ->errorCorrection('H')
                ->generate($url);

            // Adicionar espaço extra para o ID abaixo do QR code (usando GD)
            $qrSize = 750; // Tamanho original do QR code
            $padding = 30; // Espaço extra para o texto do ID

            // Criar uma nova imagem com espaço extra na parte inferior
            $newImage = imagecreatetruecolor($qrSize, $qrSize + $padding);
            $white = imagecolorallocate($newImage, 255, 255, 255);
            $black = imagecolorallocate($newImage, 0, 0, 0);
            imagefill($newImage, 0, 0, $white);

            // Adicionar o QR Code à nova imagem
            $sourceImage = imagecreatefromstring($qrCodeImage);
            if ($sourceImage === false) {
                 // Log ou tratamento de erro se imagecreatefromstring falhar
                 continue; // Pular este ID ou retornar erro
            }
            imagecopy($newImage, $sourceImage, 0, 0, 0, 0, $qrSize, $qrSize);
            imagedestroy($sourceImage);

            // Adicionar o ID do QR Code à imagem
            $fontSize = 5; // GD font size (1-5)
            $text = "ID: " . $id;
            $textWidth = imagefontwidth($fontSize) * strlen($text);

            // Posicionar o texto centralizado abaixo do QR code
            $x = ($qrSize - $textWidth) / 2;
            $y = $qrSize + ($padding / 2) - (imagefontheight($fontSize) / 2); // Centralizar verticalmente no padding
            imagestring($newImage, $fontSize, $x, $y, $text, $black);

            // Salvar a imagem como arquivo PNG
            if (imagepng($newImage, $filename)) {
                $generatedFiles[] = basename($filename);
            } else {
                 // Log ou tratamento de erro se imagepng falhar
            }
            imagedestroy($newImage);
        }

        $message = "Geração de QR codes concluída para IDs de {$startId} a {$endId}.\n";
        $message .= count($generatedFiles) . " arquivos gerados em: " . $outputDir . "\n";
        // $message .= "Arquivos: " . implode(', ', $generatedFiles); // Descomente se quiser listar os arquivos

        // Retornar uma resposta simples (pode ser JSON ou view)
        return response($message)->header('Content-Type', 'text/plain');
    }
}
