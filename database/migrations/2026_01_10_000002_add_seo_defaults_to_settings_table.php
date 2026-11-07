<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('site_meta_title_suffix')->nullable()->after('footer_text');
            $table->text('default_meta_description')->nullable()->after('site_meta_title_suffix');
            $table->string('og_image')->nullable()->after('default_meta_description');
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['site_meta_title_suffix', 'default_meta_description', 'og_image']);
        });
    }
};