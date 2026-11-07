<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->boolean('is_admin_reply')->default(false)->after('status');
            $table->foreignId('admin_id')->nullable()->after('is_admin_reply')->constrained('admins')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign(['admin_id']);
            $table->dropColumn(['is_admin_reply', 'admin_id']);
        });
    }
};