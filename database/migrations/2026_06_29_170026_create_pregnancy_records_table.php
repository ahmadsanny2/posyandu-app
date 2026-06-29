<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pregnancy_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pregnant_woman_id')->constrained('pregnant_women')->onDelete('cascade');
            $table->foreignId('schedule_id')->constrained('schedules')->onDelete('cascade');
            $table->decimal('weight_kg', 5, 2);
            $table->string('blood_pressure');
            $table->decimal('upper_arm_circumference_cm', 5, 2);
            $table->integer('gestational_age_weeks');
            $table->integer('fetal_heart_rate')->nullable();
            $table->text('action_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pregnancy_records');
    }
};
