<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update all vehicles with 'available' status to 'active'
        DB::table('vehicles')
            ->where('status', 'available')
            ->update(['status' => 'active']);

        // Update default for new vehicles
        Schema::table('vehicles', function (Blueprint $table) {
            $table->string('status')->default('active')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->string('status')->default('available')->change();
        });

        DB::table('vehicles')
            ->where('status', 'active')
            ->update(['status' => 'available']);
    }
};
