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
        Schema::create('route_recommendations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('route_analysis_id')->constrained('route_analyses')->onDelete('cascade');
            $table->foreignId('trip_id')->constrained('trips')->onDelete('cascade');
            $table->text('alternative_route');
            $table->decimal('estimated_time_saved', 8, 2)->default(0); // in minutes
            $table->decimal('actual_time_saved', 8, 2)->nullable(); // in minutes (after driver accepts and completes)
            $table->boolean('accepted_by_driver')->default(false);
            $table->decimal('distance', 10, 2)->default(0);
            $table->integer('confidence_level')->default(75); // 0-100
            $table->enum('status', ['pending', 'accepted', 'rejected', 'expired'])->default('pending');
            $table->timestamps();
            
            // Create indexes for efficient querying
            $table->index('route_analysis_id');
            $table->index('trip_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('route_recommendations');
    }
};
