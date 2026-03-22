<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TrafficDataSeeder extends Seeder
{
    public function run(): void
    {
        $routes = [
            ['trip_id'=>1, 'lat'=>9.3068,  'lng'=>123.3054, 'speed'=>62.5, 'congestion'=>'low'],
            ['trip_id'=>2, 'lat'=>10.3157, 'lng'=>123.8854, 'speed'=>18.3, 'congestion'=>'high'],
            ['trip_id'=>3, 'lat'=>7.0644,  'lng'=>125.6078, 'speed'=>45.0, 'congestion'=>'moderate'],
            ['trip_id'=>4, 'lat'=>14.5995, 'lng'=>120.9842, 'speed'=>8.7,  'congestion'=>'severe'],
            ['trip_id'=>5, 'lat'=>10.7202, 'lng'=>122.5621, 'speed'=>55.2, 'congestion'=>'low'],
            ['trip_id'=>6, 'lat'=>6.9214,  'lng'=>122.0790, 'speed'=>38.4, 'congestion'=>'moderate'],
            ['trip_id'=>7, 'lat'=>6.1164,  'lng'=>125.1716, 'speed'=>72.1, 'congestion'=>'low'],
            ['trip_id'=>8, 'lat'=>8.4542,  'lng'=>124.6319, 'speed'=>22.9, 'congestion'=>'high'],
            ['trip_id'=>9, 'lat'=>10.6765, 'lng'=>122.9509, 'speed'=>48.6, 'congestion'=>'low'],
            ['trip_id'=>10,'lat'=>10.2769, 'lng'=>123.6381, 'speed'=>14.2, 'congestion'=>'severe'],
        ];

        $vehicleIds = DB::table('vehicles')->pluck('id')->toArray();
        if (empty($vehicleIds)) $vehicleIds = [1];
        $tripIds = DB::table('trips')->pluck('id')->toArray();

        $now = Carbon::now();
        $records = [];

        foreach ($routes as $index => $r) {
            $vehicleId = $vehicleIds[$index % count($vehicleIds)];
            $tripId = !empty($tripIds) ? $tripIds[$index % count($tripIds)] : $r['trip_id'];
            $isCongested = in_array($r['congestion'], ['severe', 'high', 'moderate']);

            for ($i = 0; $i < 6; $i++) {
                // Congested = exact same coordinates every record
                // so GROUP BY lat/lng gives incident_count > 2 (hotspot threshold)
                $lat = $isCongested ? $r['lat'] : $r['lat'] + (rand(-5,5)/10000);
                $lng = $isCongested ? $r['lng'] : $r['lng'] + (rand(-5,5)/10000);

                $records[] = [
                    'vehicle_id'       => $vehicleId,
                    'trip_id'          => $tripId,
                    'latitude'         => $lat,
                    'longitude'        => $lng,
                    'speed'            => max(0, $r['speed'] + rand(-20,20)/10),
                    'heading'          => rand(0, 359),
                    'congestion_level' => $r['congestion'],
                    'timestamp'        => $now->copy()->subMinutes($i * 15)->subSeconds(rand(0,59)),
                    'created_at'       => $now->copy()->subMinutes($i * 15),
                    'updated_at'       => $now->copy()->subMinutes($i * 15),
                ];
            }
        }

        DB::table('traffic_data')->truncate();
        DB::table('traffic_data')->insert($records);

        $hotspotCount = count(array_filter($routes, fn($r) => $r['congestion'] !== 'low'));
        $this->command->info("Seeded " . count($records) . " records. $hotspotCount hotspot locations will appear on the map.");
    }
}