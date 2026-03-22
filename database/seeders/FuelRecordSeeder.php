<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FuelRecord;
use App\Models\Vehicle;

class FuelRecordSeeder extends Seeder
{
    public function run(): void
    {
        $vehicles = Vehicle::all();

        if ($vehicles->isEmpty()) {
            $this->command->warn('No vehicles found. Run VehicleSeeder first.');
            return;
        }

        $fuelTypes   = ['Diesel', 'Diesel', 'Gasoline (RON 95)', 'Gasoline (RON 91)', 'Diesel'];
        $gasStations = ['Petron', 'Shell', 'Caltex', 'Phoenix', 'Seaoil', 'Total'];
        $prices      = ['Diesel' => 58.50, 'Gasoline (RON 95)' => 65.00, 'Gasoline (RON 91)' => 62.00];

        $odometer = 15000;

        foreach ($vehicles as $vehicle) {
            for ($i = 0; $i < 3; $i++) {
                $fuelType       = $fuelTypes[array_rand($fuelTypes)];
                $pricePerLiter  = $prices[$fuelType] ?? 58.50;
                $quantity       = rand(30, 60) + (rand(0, 99) / 100);
                $totalCost      = round($quantity * $pricePerLiter, 2);
                $odometer      += rand(500, 2000);

                FuelRecord::create([
                    'vehicle_id'      => $vehicle->id,
                    'fuel_type'       => $fuelType,
                    'quantity'        => $quantity,
                    'price_per_liter' => $pricePerLiter,
                    'cost'            => $totalCost,
                    'date'            => now()->subDays(rand(1, 90)),
                    'odometer'        => $odometer,
                    'gas_station'     => $gasStations[array_rand($gasStations)],
                    'notes'           => null,
                ]);
            }
        }
    }
}