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
        Schema::table('usuarios', function (Blueprint $table) {
            $table->integer('meses_gratuitos')->default(0)->after('limite_disponivel');
            $table->decimal('valor_mensalidade', 10, 2)->default(0.00)->after('meses_gratuitos');
            $table->date('data_fim_gratuidade')->nullable()->after('valor_mensalidade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->dropColumn(['meses_gratuitos', 'valor_mensalidade', 'data_fim_gratuidade']);
        });
    }
};
