<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('establishment_onboardings', function (Blueprint $table) {
            $table->boolean('document_approved')->default(false)->after('document_path');
            $table->timestamp('document_approved_at')->nullable()->after('document_approved');
            $table->foreignId('approved_by_user_id')->nullable()->after('document_approved_at')->constrained('users')->nullOnDelete();
            $table->text('approval_notes')->nullable()->after('approved_by_user_id');
        });
    }

    public function down(): void
    {
        Schema::table('establishment_onboardings', function (Blueprint $table) {
            $table->dropForeign(['approved_by_user_id']);
            $table->dropColumn(['document_approved', 'document_approved_at', 'approved_by_user_id', 'approval_notes']);
        });
    }
};