<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('theme_primary_color', 7)->nullable()->after('custom_head_scripts');
            $table->string('theme_font')->nullable()->after('theme_primary_color');
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['theme_primary_color', 'theme_font']);
        });
    }
};