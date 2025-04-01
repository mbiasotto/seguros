<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Limpar a tabela pivot establishment_qr_code primeiro para evitar erros de chave estrangeira
        Schema::disableForeignKeyConstraints();
        DB::table('establishment_qr_code')->truncate();

        // Limpar a tabela qr_codes
        DB::table('qr_codes')->truncate();
        Schema::enableForeignKeyConstraints();

        // Não é necessário resetar o auto-incremento, o SQLite faz isso automaticamente após o truncate
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Não é possível reverter a limpeza da tabela
    }
};