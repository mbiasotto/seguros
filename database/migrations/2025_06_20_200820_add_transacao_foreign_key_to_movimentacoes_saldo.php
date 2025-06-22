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
        Schema::table('movimentacoes_saldo', function (Blueprint $table) {
            $table->foreign('transacao_id')->references('id')->on('transacoes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movimentacoes_saldo', function (Blueprint $table) {
            $table->dropForeign(['transacao_id']);
        });
    }
};
