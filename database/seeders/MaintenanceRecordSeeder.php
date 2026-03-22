<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MaintenanceRecord;
use App\Models\Vehicle;

class MaintenanceRecordSeeder extends Seeder
{
    public function run(): void
    {
        $vehicles = Vehicle::all();

        if ($vehicles->isEmpty()) {
            $this->command->warn('No vehicles found. Run VehicleSeeder first.');
            return;
        }

        $issues = [
            ['issue' => 'Oil Change',              'cost' => 850.00,   'technician' => 'Rolando Aquino'],
            ['issue' => 'Brake Pad Replacement',   'cost' => 3500.00,  'technician' => 'Ernesto Lim'],
            ['issue' => 'Tire Rotation',            'cost' => 500.00,   'technician' => 'Rolando Aquino'],
            ['issue' => 'Battery Replacement',      'cost' => 4500.00,  'technician' => 'Benigno Cruz'],
            ['issue' => 'Air Filter Replacement',   'cost' => 750.00,   'technician' => 'Ernesto Lim'],
            ['issue' => 'Transmission Fluid Change','cost' => 1200.00,  'technician' => 'Benigno Cruz'],
            ['issue' => 'Coolant Flush',            'cost' => 900.00,   'technician' => 'Rolando Aquino'],
            ['issue' => 'Spark Plug Replacement',   'cost' => 1800.00,  'technician' => 'Ernesto Lim'],
            ['issue' => 'Wheel Alignment',          'cost' => 650.00,   'technician' => 'Benigno Cruz'],
            ['issue' => 'Engine Tune-up',           'cost' => 2500.00,  'technician' => 'Rolando Aquino'],
            ['issue' => 'Power Steering Fluid',     'cost' => 400.00,   'technician' => 'Ernesto Lim'],
            ['issue' => 'Wiper Blade Replacement',  'cost' => 350.00,   'technician' => 'Benigno Cruz'],
            ['issue' => 'Radiator Flush',           'cost' => 1100.00,  'technician' => 'Rolando Aquino'],
            ['issue' => 'Clutch Replacement',       'cost' => 8500.00,  'technician' => 'Ernesto Lim'],
            ['issue' => 'Fan Belt Replacement',     'cost' => 1500.00,  'technician' => 'Benigno Cruz'],
        ];

        foreach ($issues as $i => $item) {
            MaintenanceRecord::create([
                'vehicle_id'     => $vehicles[$i % $vehicles->count()]->id,
                'issue'          => $item['issue'],
                'service_date'   => now()->subDays(rand(10, 180)),
                'cost'           => $item['cost'],
                'technician_name' => $item['technician'],
            ]);
        }
    }
}