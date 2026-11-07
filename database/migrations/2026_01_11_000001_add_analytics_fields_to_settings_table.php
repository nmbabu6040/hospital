<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('google_analytics_id')->nullable()->after('og_image');
            $table->string('google_tag_manager_id')->nullable()->after('google_analytics_id');
            $table->string('facebook_pixel_id')->nullable()->after('google_tag_manager_id');
            $table->string('google_site_verification')->nullable()->after('facebook_pixel_id');
            $table->text('custom_head_scripts')->nullable()->after('google_site_verification');
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'google_analytics_id', 'google_tag_manager_id', 'facebook_pixel_id',
                'google_site_verification', 'custom_head_scripts',
            ]);
        });
    }
};