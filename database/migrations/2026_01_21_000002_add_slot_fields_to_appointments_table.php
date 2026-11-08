<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->time('slot_time')->nullable()->after('date');
            $table->time('slot_end_time')->nullable()->after('slot_time');
            $table->string('serial_no')->nullable()->after('slot_end_time');
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn(['slot_time', 'slot_end_time', 'serial_no']);
        });
    }
};