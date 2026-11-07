<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('online_report_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('online_report_id')->constrained('online_reports')->cascadeOnDelete();
            $table->string('test_name');
            $table->string('result_value')->nullable();
            $table->string('unit')->nullable();
            $table->string('normal_range')->nullable();
            $table->boolean('is_abnormal')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('online_report_items');
    }
};