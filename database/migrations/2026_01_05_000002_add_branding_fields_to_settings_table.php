<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('footer_logo')->nullable()->after('logo');
            $table->string('favicon')->nullable()->after('footer_logo');
            $table->boolean('maintenance_mode')->default(false)->after('footer_text');
            $table->text('maintenance_message')->nullable()->after('maintenance_mode');
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['footer_logo', 'favicon', 'maintenance_mode', 'maintenance_message']);
        });
    }
};