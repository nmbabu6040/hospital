<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->enum('role', ['super_admin', 'branch_admin', 'editor'])->default('editor')->after('email');
            $table->foreignId('branch_id')->nullable()->after('role')->constrained('branches')->nullOnDelete();
            $table->boolean('is_active')->default(true)->after('branch_id');
        });
    }

    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropForeign(['branch_id']);
            $table->dropColumn(['role', 'branch_id', 'is_active']);
        });
    }
};