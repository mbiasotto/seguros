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
        Schema::create('movimentacoes_saldo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('saldo_id')->constrained('saldos')->onDelete('cascade');
            $table->unsignedBigInteger('transacao_id')->nullable();
            $table->enum('tipo_movimentacao', ['credito', 'debito']);
            $table->decimal('valor', 10, 2);
            $table->string('descricao');
            $table->decimal('saldo_anterior', 10, 2);
            $table->decimal('saldo_posterior', 10, 2);
            $table->timestamps();

            // Índices para performance
            $table->index(['saldo_id', 'created_at']);
            $table->index('transacao_id');
            $table->index('tipo_movimentacao');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimentacoes_saldo');
    }
};
