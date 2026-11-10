<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('google_business_profile_url')->nullable()->after('google_site_verification');
            $table->decimal('google_rating', 2, 1)->nullable()->after('google_business_profile_url');
            $table->unsignedInteger('google_review_count')->nullable()->after('google_rating');
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['google_business_profile_url', 'google_rating', 'google_review_count']);
        });
    }
};