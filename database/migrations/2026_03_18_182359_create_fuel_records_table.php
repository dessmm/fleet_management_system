<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fuel_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained('vehicles')->onDelete('cascade');
            $table->string('fuel_type');
            $table->decimal('quantity', 8, 2);
            $table->decimal('price_per_liter', 8, 2)->nullable();
            $table->decimal('cost', 10, 2);
            $table->integer('odometer')->nullable();
            $table->string('gas_station')->nullable();
            $table->text('notes')->nullable();
            $table->date('date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fuel_records');
    }
};