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
        Schema::create('elderly_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('elderly_id')->constrained('elderlies')->onDelete('cascade');
            $table->foreignId('schedule_id')->constrained('schedules')->onDelete('cascade');
            $table->decimal('weight_kg', 5, 2);
            $table->string('blood_pressure');
            $table->integer('blood_sugar')->nullable();
            $table->integer('cholesterol')->nullable();
            $table->decimal('uric_acid', 4, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('elderly_records');
    }
};
