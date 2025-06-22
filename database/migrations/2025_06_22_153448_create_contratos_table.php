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
        Schema::create('contratos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('clientes')->onDelete('cascade');
            $table->string('numero_contrato')->unique();
            $table->enum('tipo', ['site', 'avulso']);
            $table->string('documento_identidade_url');
            $table->enum('status', ['pendente_cpfl', 'ativo', 'cancelado'])->default('pendente_cpfl');
            $table->timestamp('enviado_cpfl_em')->nullable();
            $table->string('protocolo_cpfl')->nullable();
            $table->string('protocolo_cancelamento')->nullable();
            $table->integer('score_inicial')->nullable();
            $table->decimal('limite_inicial', 10, 2)->default(0.00);
            $table->date('data_proxima_revisao_score')->nullable();
            $table->timestamps();

            // Índices para performance
            $table->index(['usuario_id', 'status']);
            $table->index('status');
            $table->index('data_proxima_revisao_score');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contratos');
    }
};
