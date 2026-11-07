<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hospital_stats', function (Blueprint $table) {
            $table->id();
            $table->date('stat_date');
            $table->foreignId('hospital_id')->nullable()->constrained('hospitals')->nullOnDelete();
            $table->foreignId('branch_id')->nullable()->constrained('branches')->nullOnDelete();
            $table->unsignedInteger('patients_admitted')->default(0);
            $table->unsignedInteger('patients_discharged')->default(0);
            $table->unsignedInteger('test_only_patients')->default(0);
            $table->unsignedInteger('opd_patients')->default(0);
            $table->unsignedInteger('emergency_patients')->default(0);
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('admins')->nullOnDelete();
            $table->timestamps();

            $table->unique(['stat_date', 'hospital_id', 'branch_id'], 'unique_stat_per_day_hospital_branch');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hospital_stats');
    }
};