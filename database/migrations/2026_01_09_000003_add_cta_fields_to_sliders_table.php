<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->text('description')->nullable()->after('subtitle');
            $table->string('cta_text')->nullable()->after('description');
            $table->string('cta_url')->nullable()->after('cta_text');
            $table->string('cta_text_2')->nullable()->after('cta_url');
            $table->string('cta_url_2')->nullable()->after('cta_text_2');
        });
    }

    public function down(): void
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->dropColumn(['description', 'cta_text', 'cta_url', 'cta_text_2', 'cta_url_2']);
        });
    }
};