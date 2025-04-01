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
            if (!Schema::hasColumn('establishments', 'email')) {
                $table->string('email')->nullable()->after('telefone');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('establishments', function (Blueprint $table) {
            if (Schema::hasColumn('establishments', 'email')) {
                $table->dropColumn('email');
            }
        });
    }
};