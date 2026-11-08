<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->boolean('live_chat_enabled')->default(false)->after('email_notifications_enabled');
            $table->string('tawk_to_property_id')->nullable()->after('live_chat_enabled');
            $table->string('tawk_to_widget_id')->nullable()->after('tawk_to_property_id');
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['live_chat_enabled', 'tawk_to_property_id', 'tawk_to_widget_id']);
        });
    }
};