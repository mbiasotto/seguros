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
        Schema::table('establishment_onboardings', function (Blueprint $table) {
            $table->json('contract_metadata')->nullable()->after('ip_address')
                ->comment('Dados adicionais de validação do aceite do contrato');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('establishment_onboardings', function (Blueprint $table) {
            $table->dropColumn('contract_metadata');
        });
    }
};
