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
        Schema::create('recargas_prepago', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('usuarios')->onDelete('cascade');
            $table->decimal('valor', 10, 2);
            $table->string('forma_pagamento');
            $table->enum('status', ['pendente', 'confirmado', 'cancelado'])->default('pendente');
            $table->string('comprovante_url')->nullable();
            $table->foreignId('confirmado_por_admin_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('data_confirmacao')->nullable();
            $table->timestamps();

            // Índices para performance
            $table->index(['usuario_id', 'status']);
            $table->index('status');
            $table->index('data_confirmacao');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recargas_prepago');
    }
};
