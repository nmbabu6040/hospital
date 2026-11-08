<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('queue_displays', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->unique()->constrained('doctors')->cascadeOnDelete();
            $table->string('current_serial')->nullable();
            $table->date('queue_date')->nullable();
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('queue_displays');
    }
};