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
        Schema::table('clientes', function (Blueprint $table) {
            $table->string('numero_cartao')->unique()->nullable()->after('limite_disponivel');
            $table->date('validade_cartao')->nullable()->after('numero_cartao');
            $table->decimal('limite_credito_manual', 10, 2)->nullable()->after('validade_cartao');
            $table->decimal('limite_credito_sugerido', 10, 2)->nullable()->after('limite_credito_manual');
            $table->text('motivo_limite_manual')->nullable()->after('limite_credito_sugerido');
            $table->integer('score_atual')->nullable()->after('motivo_limite_manual');
            $table->timestamp('data_ultima_consulta_score')->nullable()->after('score_atual');
            $table->foreignId('limite_aprovado_por')->nullable()->constrained('users')->onDelete('set null')->after('data_ultima_consulta_score');
            $table->timestamp('data_aprovacao_limite')->nullable()->after('limite_aprovado_por');

            // Índices para performance
            $table->index('numero_cartao');
            $table->index('score_atual');
            $table->index('data_ultima_consulta_score');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropForeign(['limite_aprovado_por']);
            $table->dropIndex(['numero_cartao']);
            $table->dropIndex(['score_atual']);
            $table->dropIndex(['data_ultima_consulta_score']);

            $table->dropColumn([
                'numero_cartao',
                'validade_cartao',
                'limite_credito_manual',
                'limite_credito_sugerido',
                'motivo_limite_manual',
                'score_atual',
                'data_ultima_consulta_score',
                'limite_aprovado_por',
                'data_aprovacao_limite'
            ]);
        });
    }
};
