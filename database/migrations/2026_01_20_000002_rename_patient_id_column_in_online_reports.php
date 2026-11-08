<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('online_reports', function (Blueprint $table) {
            $table->renameColumn('patient_id', 'patient_ref_id');
        });
    }

    public function down(): void
    {
        Schema::table('online_reports', function (Blueprint $table) {
            $table->renameColumn('patient_ref_id', 'patient_id');
        });
    }
};