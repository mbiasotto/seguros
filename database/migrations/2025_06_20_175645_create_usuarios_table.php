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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('cpf', 11)->unique();
            $table->string('nome');
            $table->string('email')->unique();
            $table->string('telefone');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            // Dados da conta CPFL
            $table->string('conta_cpfl')->nullable();
            $table->decimal('limite_total', 10, 2)->default(0);
            $table->decimal('limite_disponivel', 10, 2)->default(0);

            // Status do usuário
            $table->enum('status', ['pendente', 'ativo', 'bloqueado'])->default('pendente');

            // Endereço
            $table->string('endereco');
            $table->string('cidade');
            $table->string('estado', 2);
            $table->string('cep', 8);

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
        Schema::dropIfExists('usuarios');
    }
};
