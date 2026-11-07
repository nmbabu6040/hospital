<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('about_contents', function (Blueprint $table) {
            $table->id();
            $table->string('md_name')->nullable();
            $table->string('md_designation')->nullable();
            $table->string('md_image')->nullable();
            $table->text('md_message')->nullable();
            $table->text('about_text')->nullable();
            $table->string('about_image')->nullable();
            $table->unsignedInteger('patients_count')->default(0);
            $table->unsignedInteger('staff_count')->default(0);
            $table->unsignedInteger('doctors_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_contents');
    }
};