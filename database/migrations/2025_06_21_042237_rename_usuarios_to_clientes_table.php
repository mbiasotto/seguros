<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Renomear tabela usuarios para clientes
        Schema::rename('usuarios', 'clientes');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverter: renomear clientes para usuarios
        Schema::rename('clientes', 'usuarios');
    }
};
