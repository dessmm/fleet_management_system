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
        Schema::create('location_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained('vehicles')->onDelete('cascade');
            $table->foreignId('trip_id')->nullable()->constrained('trips')->onDelete('set null');
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->decimal('speed', 8, 2); // in km/h
            $table->integer('heading')->nullable(); // 0-360 degrees
            $table->decimal('altitude', 10, 2)->nullable(); // in meters
            $table->decimal('accuracy', 8, 2)->nullable(); // in meters
            $table->dateTime('recorded_at');
            $table->timestamps();
            
            // Create indexes for efficient querying
            $table->index(['vehicle_id', 'recorded_at']);
            $table->index(['trip_id', 'recorded_at']);
            $table->index('recorded_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('location_logs');
    }
};
