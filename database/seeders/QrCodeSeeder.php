<?php

namespace Database\Seeders;

use App\Models\QrCode;
use Illuminate\Database\Seeder;

class QrCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Criar 100 QR codes
        for ($i = 1; $i <= 100; $i++) {
            QrCode::create([
                'title' => 'QR Code ' . $i,
                'link' => 'https://seguraessa.app/qr-code/' . $i,
                'description' => 'QR Code gerado automaticamente',
                'active' => true,
            ]);
        }

        $this->command->info('100 QR Codes foram criados com sucesso!');
    }
}