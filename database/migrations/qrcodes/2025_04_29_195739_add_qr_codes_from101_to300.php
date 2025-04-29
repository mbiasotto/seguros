<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\QrCode;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Inserir QR codes de 101 a 300
        for ($i = 101; $i <= 300; $i++) {
            QrCode::create([
                'title' => 'QR Code ' . $i,
                'link' => 'https://seguraessa.app/qr-code/' . $i,
                'description' => 'QR Code gerado automaticamente',
                'active' => true,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remover os QR codes de 101 a 300
        QrCode::where('id', '>=', 101)->where('id', '<=', 300)->delete();
        // Atenção: Esta lógica de rollback assume que os IDs serão sequenciais
        // e que não haverá outras inserções concorrentes que afetem os IDs
        // Se a coluna 'id' não for garantidamente sequencial ou se houver risco,
        // pode ser mais seguro usar o 'link' ou 'title' para identificar os registros a remover.
        // Exemplo alternativo para o down():
        // for ($i = 101; $i <= 300; $i++) {
        //     QrCode::where('link', 'https://seguraessa.app/qr-code/' . $i)->delete();
        // }
    }
};
