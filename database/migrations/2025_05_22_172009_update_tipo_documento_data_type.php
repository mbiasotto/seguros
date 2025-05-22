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
        // Para SQLite, precisamos recriar a tabela com o tipo correto
        if (DB::connection()->getDriverName() === 'sqlite') {
            // Primeiro, verificamos se a coluna existe
            $columns = DB::select("PRAGMA table_info(establishments)");
            $hasTipoDocumento = false;
            foreach ($columns as $column) {
                if ($column->name === 'tipo_documento') {
                    $hasTipoDocumento = true;
                    break;
                }
            }

            if ($hasTipoDocumento) {
                // Criamos uma tabela temporária
                Schema::create('establishments_temp', function (Blueprint $table) {
                    $table->id();
                    $table->foreignId('vendor_id')->constrained()->onDelete('cascade');
                    $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
                    $table->string('nome');
                    $table->enum('tipo_documento', ['pj', 'pf'])->default('pj');
                    $table->string('cnpj')->nullable();
                    $table->string('cpf')->nullable();
                    $table->string('endereco');
                    $table->string('numero')->nullable();
                    $table->string('cidade');
                    $table->string('estado');
                    $table->string('cep');
                    $table->string('telefone');
                    $table->string('email')->nullable();
                    $table->text('descricao')->nullable();
                    $table->boolean('ativo')->default(true);
                    $table->string('logo')->nullable();
                    $table->string('image')->nullable();
                    $table->timestamps();
                });

                // Copiamos os dados
                DB::statement('INSERT INTO establishments_temp
                    SELECT id, vendor_id, category_id, nome, tipo_documento, cnpj, cpf, endereco, numero, cidade, estado, cep, telefone, email, descricao, ativo, logo, image, created_at, updated_at
                    FROM establishments');

                // Excluímos a tabela antiga
                Schema::drop('establishments');

                // Renomeamos a tabela temporária
                Schema::rename('establishments_temp', 'establishments');
            }
        } else {
            // Para outros bancos de dados, podemos modificar a coluna diretamente
            Schema::table('establishments', function (Blueprint $table) {
                $table->enum('tipo_documento', ['pj', 'pf'])->default('pj')->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Esta migração não tem rollback seguro para SQLite
        if (DB::connection()->getDriverName() !== 'sqlite') {
            Schema::table('establishments', function (Blueprint $table) {
                $table->string('tipo_documento')->default('pj')->change();
            });
        }
    }
};
