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
        Schema::create('traffic_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained('vehicles')->onDelete('cascade');
            $table->foreignId('trip_id')->nullable()->constrained('trips')->onDelete('set null');
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->decimal('speed', 8, 2); // in km/h
            $table->integer('heading')->nullable(); // 0-360 degrees
            $table->dateTime('timestamp');
            $table->enum('congestion_level', ['low', 'moderate', 'high', 'severe'])->default('low');
            $table->timestamps();
            
            // Create index for querying by vehicle and timestamp
            $table->index(['vehicle_id', 'timestamp']);
            $table->index(['trip_id', 'timestamp']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('traffic_data');
    }
};
