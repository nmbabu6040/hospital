<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('online_reports', function (Blueprint $table) {
            $table->string('referred_by')->nullable()->after('patient_id');
            $table->string('age')->nullable()->after('referred_by');
            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable()->after('age');
            $table->text('comment')->nullable()->after('report_date');
            $table->string('verified_by')->nullable()->after('comment');
        });
    }

    public function down(): void
    {
        Schema::table('online_reports', function (Blueprint $table) {
            $table->dropColumn(['referred_by', 'age', 'gender', 'comment', 'verified_by']);
        });
    }
};