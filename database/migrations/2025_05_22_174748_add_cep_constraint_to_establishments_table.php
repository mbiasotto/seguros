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
        // Verificar o driver do banco de dados
        $driver = DB::connection()->getDriverName();

        if ($driver === 'sqlite') {
            // Verificar se a coluna 'cep' existe
            $hasCep = false;
            $columns = DB::select("PRAGMA table_info(establishments)");
            foreach ($columns as $column) {
                if ($column->name === 'cep') {
                    $hasCep = true;
                    break;
                }
            }

            // Se a coluna não existir, vamos criar uma tabela temporária com a estrutura correta
            if (!$hasCep) {
                // Primeiro criar uma tabela temporária com a estrutura atualizada
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

                // Copiar os dados existentes
                $fields = implode(', ', [
                    'id', 'vendor_id', 'category_id', 'nome', 'tipo_documento',
                    'cnpj', 'cpf', 'endereco', 'numero', 'cidade', 'estado',
                    "''" . ' as cep', // Valor vazio para o campo cep para registros existentes
                    'telefone', 'email', 'descricao', 'ativo', 'logo', 'image',
                    'created_at', 'updated_at'
                ]);

                DB::statement("INSERT INTO establishments_temp SELECT {$fields} FROM establishments");

                // Excluir a tabela original
                Schema::drop('establishments');

                // Renomear a tabela temporária
                Schema::rename('establishments_temp', 'establishments');
            }
        } else {
            // Para MySQL, PostgreSQL, etc.
            Schema::table('establishments', function (Blueprint $table) {
                if (!Schema::hasColumn('establishments', 'cep')) {
                    $table->string('cep')->after('estado');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Não é necessário remover a coluna "cep" pois ela é essencial para o sistema
    }
};
