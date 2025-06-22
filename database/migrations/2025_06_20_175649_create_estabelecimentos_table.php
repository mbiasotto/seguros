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
        Schema::create('estabelecimentos', function (Blueprint $table) {
            $table->id();
            $table->string('cnpj', 14)->unique();
            $table->string('razao_social');
            $table->string('nome_fantasia');
            $table->string('email')->unique();
            $table->string('telefone');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            // Endereço completo
            $table->string('endereco');
            $table->string('numero');
            $table->string('bairro');
            $table->string('cidade');
            $table->string('estado', 2);
            $table->string('cep', 8);

            // Categoria e taxas
            $table->foreignId('categoria_id')->constrained('categorias');
            $table->decimal('taxa_multiplic', 5, 2);
            $table->decimal('taxa_estabelecimento', 5, 2);

            // Status
            $table->enum('status', ['pendente', 'ativo', 'bloqueado'])->default('pendente');

            // Auditoria
            $table->foreignId('criado_por_admin_id')->constrained('users');

            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estabelecimentos');
    }
};
