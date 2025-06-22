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
        Schema::create('saldos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('usuarios')->onDelete('cascade');
            $table->enum('tipo', ['pre_pago', 'mensalidade', 'limite_consignado']);
            $table->decimal('valor_disponivel', 10, 2)->default(0.00);
            $table->decimal('valor_original', 10, 2);
            $table->datetime('data_credito');
            $table->datetime('data_expiracao')->nullable();
            $table->enum('status', ['ativo', 'utilizado', 'expirado'])->default('ativo');
            $table->timestamps();

            // Índices para performance
            $table->index(['usuario_id', 'status']);
            $table->index(['tipo', 'status']);
            $table->index('data_expiracao');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saldos');
    }
};
