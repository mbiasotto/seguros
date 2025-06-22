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
        Schema::create('faturamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained()->onDelete('cascade');
            $table->string('mes_referencia', 7); // YYYY-MM format
            $table->decimal('valor_transacoes', 10, 2)->default(0);
            $table->decimal('valor_mensalidade', 10, 2)->default(0);
            $table->decimal('valor_total', 10, 2)->default(0);
            $table->string('conta_cpfl')->nullable();
            $table->enum('status', ['aberto', 'fechado', 'enviado', 'pago'])->default('aberto');
            $table->timestamp('arquivo_cpfl_gerado_em')->nullable();
            $table->timestamp('enviado_em')->nullable();
            $table->timestamp('pago_em')->nullable();
            $table->timestamps();

            // Índices para performance
            $table->unique(['usuario_id', 'mes_referencia']);
            $table->index('mes_referencia');
            $table->index('status');
            $table->index('conta_cpfl');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faturamentos');
    }
};
