<?php

require __DIR__ . '/vendor/autoload.php';

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\File;

// Carregar o ambiente Laravel para ter acesso às funções de rota
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Diretório onde os QR codes serão salvos
$outputDir = __DIR__ . '/public/qr_codes';

// Criar o diretório se não existir
if (!file_exists($outputDir)) {
    mkdir($outputDir, 0755, true);
}

echo "Iniciando geração de QR codes...\n";

// Definir o domínio base para os QR codes
$baseUrl = 'https://seguraessa.app';

// Gerar 100 QR codes
for ($id = 101; $id <= 300; $id++) {
    // URL para o QR code
    $url = $baseUrl . '/qr-code/' . $id;

    // Nome do arquivo
    $filename = $outputDir . '/qr_code_' . $id . '.png';

    // Gerar o QR code com tamanho 750x750 pixels e margem zero
    $qrCodeImage = QrCode::format('png')
        ->size(750)
        ->margin(0) // Margem zero para maximizar o tamanho do QR code
        ->errorCorrection('H')
        ->generate($url);

    // Adicionar espaço extra para o ID abaixo do QR code
    $qrSize = 750; // Tamanho original do QR code
    $padding = 30; // Espaço extra para o texto do ID

    // Criar uma nova imagem com espaço extra na parte inferior
    $newImage = imagecreatetruecolor($qrSize, $qrSize + $padding);
    $white = imagecolorallocate($newImage, 255, 255, 255);
    imagefill($newImage, 0, 0, $white);

    // Adicionar o QR Code à nova imagem
    $image = imagecreatefromstring($qrCodeImage);
    imagecopy($newImage, $image, 0, 0, 0, 0, $qrSize, $qrSize);
    imagedestroy($image);

    // Adicionar o ID do QR Code à imagem abaixo do QR code
    $black = imagecolorallocate($newImage, 0, 0, 0);
    $fontSize = 5;
    $text = "ID: " . $id;
    $textWidth = imagefontwidth($fontSize) * strlen($text);

    // Posicionar o texto centralizado abaixo do QR code
    $x = ($qrSize - $textWidth) / 2;
    $y = $qrSize + 10; // 10 pixels abaixo do QR code
    imagestring($newImage, $fontSize, $x, $y, $text, $black);

    // Salvar a imagem como arquivo PNG
    imagepng($newImage, $filename);
    imagedestroy($newImage);

    echo "QR Code {$id} gerado: {$filename}\n";
}

echo "\nGeração de QR codes concluída!\n";
echo "Os QR codes foram salvos em: {$outputDir}\n";