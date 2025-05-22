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
        Schema::table('establishments', function (Blueprint $table) {
            $table->string('tipo_documento')->default('pj')->after('nome'); // 'pj' para pessoa jurídica, 'pf' para pessoa física
            $table->string('cpf', 14)->nullable()->after('cnpj');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('establishments', function (Blueprint $table) {
            $table->dropColumn(['tipo_documento', 'cpf']);
        });
    }
};
