<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vehicle;

class VehicleSeeder extends Seeder
{
    public function run(): void
    {
        $vehicles = [
            // Toyota
            ['plate_number' => 'ABC-1234', 'make' => 'Toyota',     'model' => 'HiAce Commuter',  'type' => 'Van',    'capacity' => 1500, 'status' => 'active'],
            ['plate_number' => 'ABC-5678', 'make' => 'Toyota',     'model' => 'Land Cruiser 76', 'type' => 'SUV',    'capacity' => 800,  'status' => 'active'],
            ['plate_number' => 'ABC-9012', 'make' => 'Toyota',     'model' => 'Coaster',         'type' => 'Bus',    'capacity' => 2000, 'status' => 'active'],
            ['plate_number' => 'ABC-3456', 'make' => 'Toyota',     'model' => 'Hilux',           'type' => 'Pickup', 'capacity' => 1000, 'status' => 'inactive'],

            // Mitsubishi
            ['plate_number' => 'DEF-1234', 'make' => 'Mitsubishi', 'model' => 'L300 FB',         'type' => 'Van',    'capacity' => 1200, 'status' => 'active'],
            ['plate_number' => 'DEF-5678', 'make' => 'Mitsubishi', 'model' => 'Fuso Fighter',    'type' => 'Truck',  'capacity' => 5000, 'status' => 'active'],
            ['plate_number' => 'DEF-9012', 'make' => 'Mitsubishi', 'model' => 'Strada',          'type' => 'Pickup', 'capacity' => 900,  'status' => 'active'],

            // Isuzu
            ['plate_number' => 'GHI-1234', 'make' => 'Isuzu',      'model' => 'Elf NKR',         'type' => 'Truck',  'capacity' => 3500, 'status' => 'active'],
            ['plate_number' => 'GHI-5678', 'make' => 'Isuzu',      'model' => 'Forward FRR',     'type' => 'Truck',  'capacity' => 7000, 'status' => 'active'],
            ['plate_number' => 'GHI-9012', 'make' => 'Isuzu',      'model' => 'D-Max',           'type' => 'Pickup', 'capacity' => 1100, 'status' => 'inactive'],

            // Ford
            ['plate_number' => 'JKL-1234', 'make' => 'Ford',       'model' => 'Ranger Wildtrak', 'type' => 'Pickup', 'capacity' => 1000, 'status' => 'active'],
            ['plate_number' => 'JKL-5678', 'make' => 'Ford',       'model' => 'Transit',         'type' => 'Van',    'capacity' => 1400, 'status' => 'active'],

            // Nissan
            ['plate_number' => 'MNO-1234', 'make' => 'Nissan',     'model' => 'Urvan NV350',     'type' => 'Van',    'capacity' => 1300, 'status' => 'active'],
            ['plate_number' => 'MNO-5678', 'make' => 'Nissan',     'model' => 'Navara',          'type' => 'Pickup', 'capacity' => 950,  'status' => 'inactive'],

            // Hyundai
            ['plate_number' => 'PQR-1234', 'make' => 'Hyundai',    'model' => 'H100 Porter',     'type' => 'Van',    'capacity' => 1100, 'status' => 'active'],
            ['plate_number' => 'PQR-5678', 'make' => 'Hyundai',    'model' => 'HD65',            'type' => 'Truck',  'capacity' => 4000, 'status' => 'active'],

            // Foton
            ['plate_number' => 'STU-1234', 'make' => 'Foton',      'model' => 'Tornado',         'type' => 'Truck',  'capacity' => 4500, 'status' => 'active'],
            ['plate_number' => 'STU-5678', 'make' => 'Foton',      'model' => 'View Transvan',   'type' => 'Van',    'capacity' => 1200, 'status' => 'active'],

            // Hino
            ['plate_number' => 'VWX-1234', 'make' => 'Hino',       'model' => '300 Series',      'type' => 'Truck',  'capacity' => 3000, 'status' => 'active'],
            ['plate_number' => 'VWX-5678', 'make' => 'Hino',       'model' => '500 Series',      'type' => 'Truck',  'capacity' => 8000, 'status' => 'inactive'],
        ];

        foreach ($vehicles as $vehicle) {
            Vehicle::create($vehicle);
        }

        $this->command->info('Created ' . count($vehicles) . ' vehicles successfully.');
    }
}