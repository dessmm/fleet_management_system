<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\Driver;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // ── Test User ─────────────────────────────────────────────
        if (!User::where('email', 'test@example.com')->exists()) {
            User::factory()->create([
                'name'  => 'Test User',
                'email' => 'test@example.com',
            ]);
        }

        // ── Seeders (only run if tables are empty) ────────────────
        if (Vehicle::count() === 0) {
            $this->call(VehicleSeeder::class);
        } else {
            $this->command->info('Vehicles already seeded — skipping.');
        }

        if (Driver::count() === 0) {
            $this->call(DriverSeeder::class);
        } else {
            $this->command->info('Drivers already seeded — skipping.');
        }

        // Trips, Maintenance, Fuel depend on vehicles & drivers existing
        $this->call(TripSeeder::class);
        $this->call(MaintenanceRecordSeeder::class);
        $this->call(FuelRecordSeeder::class);
    }
}