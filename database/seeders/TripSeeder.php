<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Trip;
use App\Models\Vehicle;
use App\Models\Driver;

class TripSeeder extends Seeder
{
    public function run(): void
    {
        $vehicles = Vehicle::all();
        $drivers  = Driver::where('status', 'active')->get();

        if ($vehicles->isEmpty() || $drivers->isEmpty()) {
            $this->command->warn('No vehicles or drivers found. Run VehicleSeeder and DriverSeeder first.');
            return;
        }

        $routes = [
            ['start' => 'Dumaguete City',  'end' => 'Bacolod City',    'distance' => 120],
            ['start' => 'Cebu City',       'end' => 'Mandaue City',    'distance' => 12],
            ['start' => 'Davao City',      'end' => 'Tagum City',      'distance' => 55],
            ['start' => 'Cagayan de Oro',  'end' => 'Iligan City',     'distance' => 35],
            ['start' => 'Iloilo City',     'end' => 'Roxas City',      'distance' => 105],
            ['start' => 'Zamboanga City',  'end' => 'Pagadian City',   'distance' => 172],
            ['start' => 'General Santos',  'end' => 'Koronadal City',  'distance' => 30],
            ['start' => 'Butuan City',     'end' => 'Surigao City',    'distance' => 87],
            ['start' => 'Tacloban City',   'end' => 'Ormoc City',      'distance' => 65],
            ['start' => 'Dumaguete City',  'end' => 'Guihulngan City', 'distance' => 48],
            ['start' => 'Cebu City',       'end' => 'Toledo City',     'distance' => 42],
            ['start' => 'Bacolod City',    'end' => 'Silay City',      'distance' => 18],
        ];

        $statuses = ['pending', 'in_progress', 'completed', 'completed', 'completed'];

        foreach ($routes as $i => $route) {
            $status    = $statuses[$i % count($statuses)];
            $startTime = now()->subDays(rand(1, 30))->setHour(rand(6, 16))->setMinute(0);
            $endTime   = $status === 'completed' ? (clone $startTime)->addMinutes(rand(60, 240)) : null;

            Trip::create([
                'vehicle_id'     => $vehicles[$i % $vehicles->count()]->id,
                'driver_id'      => $drivers[$i % $drivers->count()]->id,
                'start_location' => $route['start'],
                'end_location'   => $route['end'],
                'distance'       => $route['distance'],
                'start_time'     => $startTime,
                'end_time'       => $endTime,
                'status'         => $status,
            ]);
        }
    }
}