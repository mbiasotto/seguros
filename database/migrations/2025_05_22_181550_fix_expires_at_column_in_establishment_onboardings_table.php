<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Para o SQLite, precisamos recriar a tabela
        if (DB::connection()->getDriverName() === 'sqlite') {
            // Cria tabela temporária
            Schema::create('establishment_onboardings_temp', function (Blueprint $table) {
                $table->id();
                $table->foreignId('establishment_id');
                $table->string('token', 100)->unique();
                $table->string('document_path')->nullable();
                $table->boolean('contract_accepted')->default(false);
                $table->timestamp('contract_accepted_at')->nullable();
                $table->string('ip_address')->nullable();
                $table->boolean('completed')->default(false);
                $table->timestamp('completed_at')->nullable();
                $table->timestamp('expires_at')->nullable();
                $table->timestamps();
                $table->boolean('document_approved')->default(false);
                $table->timestamp('document_approved_at')->nullable();
                $table->foreignId('approved_by_user_id')->nullable();
                $table->text('approval_notes')->nullable();
                $table->json('contract_metadata')->nullable();
            });

            // Copia dados da tabela original para a temporária
            DB::statement('INSERT INTO establishment_onboardings_temp
                SELECT id, establishment_id, token, document_path, contract_accepted,
                contract_accepted_at, ip_address, completed, completed_at,
                CASE WHEN expires_at IS NULL THEN NULL ELSE expires_at END,
                created_at, updated_at, document_approved, document_approved_at,
                approved_by_user_id, approval_notes, contract_metadata
                FROM establishment_onboardings');

            // Remove tabela original
            Schema::drop('establishment_onboardings');

            // Renomeia tabela temporária para o nome original
            Schema::rename('establishment_onboardings_temp', 'establishment_onboardings');

            // Recria as chaves estrangeiras
            Schema::table('establishment_onboardings', function (Blueprint $table) {
                $table->foreign('establishment_id')->references('id')->on('establishments')->onDelete('cascade');
                $table->foreign('approved_by_user_id')->references('id')->on('users')->nullable();
            });
        } else {
            // Para outros bancos de dados, apenas modifica a coluna
            Schema::table('establishment_onboardings', function (Blueprint $table) {
                $table->timestamp('expires_at')->nullable()->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Não é necessário reverter esta migração
    }
};
