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

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        if (!User::where('email', 'test@example.com')->exists()) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
        }

        // Create test vehicles
        if (Vehicle::count() === 0) {
            Vehicle::create([
                'plate_number' => 'VEH001',
                'make' => 'Toyota',
                'model' => 'Camry',
                'type' => 'Sedan',
                'status' => 'available',
                'capacity' => 5,
            ]);

            Vehicle::create([
                'plate_number' => 'VEH002',
                'make' => 'Honda',
                'model' => 'Civic',
                'type' => 'Sedan',
                'status' => 'available',
                'capacity' => 5,
            ]);
        }

        // Create test drivers
        if (Driver::count() === 0) {
            Driver::create([
                'name' => 'John Doe',
                'license_number' => 'DL123456',
                'contact' => '555-0001',
                'status' => 'available',
            ]);

            Driver::create([
                'name' => 'Jane Smith',
                'license_number' => 'DL789012',
                'contact' => '555-0002',
                'status' => 'available',
            ]);
        }
    }
}
