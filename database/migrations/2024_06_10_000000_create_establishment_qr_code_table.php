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
        Schema::create('establishment_qr_code', function (Blueprint $table) {
            $table->id();
            $table->foreignId('establishment_id')->constrained()->onDelete('cascade');
            $table->foreignId('qr_code_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            // Garante que um QR code não seja associado mais de uma vez ao mesmo estabelecimento
            $table->unique(['establishment_id', 'qr_code_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('establishment_qr_code');
    }
};