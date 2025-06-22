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
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->unique();
            $table->string('descricao')->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });

        // Inserir categorias padrão
        DB::table('categorias')->insert([
            ['nome' => 'Supermercado', 'descricao' => 'Supermercados e hipermercados', 'ativo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Farmácia', 'descricao' => 'Farmácias e drogarias', 'ativo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Posto de Gasolina', 'descricao' => 'Postos de combustível', 'ativo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Restaurante', 'descricao' => 'Restaurantes e lanchonetes', 'ativo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Loja', 'descricao' => 'Lojas e comércio em geral', 'ativo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Serviços', 'descricao' => 'Prestadores de serviços', 'ativo' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categorias');
    }
};
