<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ambulance_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ambulance_id')->nullable()->constrained('ambulances')->nullOnDelete();
            $table->foreignId('patient_id')->nullable()->constrained('patients')->nullOnDelete();
            $table->string('requester_name');
            $table->string('phone');
            $table->string('pickup_location');
            $table->string('drop_location')->nullable();
            $table->enum('ambulance_type', ['Basic', 'ICU', 'Freezer'])->default('Basic');
            $table->boolean('is_emergency')->default(false);
            $table->text('additional_info')->nullable();
            $table->enum('status', ['pending', 'assigned', 'on_the_way', 'completed', 'cancelled'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ambulance_requests');
    }
};