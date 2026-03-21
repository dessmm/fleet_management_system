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
        Schema::create('route_analyses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trip_id')->constrained('trips')->onDelete('cascade');
            $table->string('original_route');
            $table->decimal('average_speed', 8, 2)->default(0);
            $table->decimal('max_speed', 8, 2)->default(0);
            $table->decimal('min_speed', 8, 2)->default(0);
            $table->decimal('total_distance', 10, 2)->default(0);
            $table->integer('estimated_time')->default(0); // in minutes
            $table->integer('actual_time')->nullable(); // in minutes
            $table->json('congestion_segments')->nullable();
            $table->dateTime('analysis_date');
            $table->timestamps();
            
            // Create index for querying by trip
            $table->index('trip_id');
            $table->index('analysis_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('route_analyses');
    }
};
