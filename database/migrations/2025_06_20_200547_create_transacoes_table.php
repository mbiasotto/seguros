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
        Schema::create('transacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained()->onDelete('cascade');
            $table->foreignId('estabelecimento_id')->constrained()->onDelete('cascade');
            $table->decimal('valor', 10, 2);
            $table->string('pin', 6)->unique();
            $table->enum('status', ['pendente', 'autorizada', 'expirada', 'cancelada'])->default('pendente');
            $table->timestamp('expires_at');
            $table->timestamp('authorized_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'expires_at']);
            $table->index(['usuario_id', 'status']);
            $table->index(['estabelecimento_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transacoes');
    }
};
