<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('online_reports', function (Blueprint $table) {
            $table->id();
            $table->string('patient_name');
            $table->string('patient_id')->nullable();
            $table->string('phone');
            $table->string('report_id')->unique();
            $table->date('report_date')->nullable();
            $table->string('status')->default('pending'); // pending / ready
            $table->string('report_file')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('online_reports');
    }
};