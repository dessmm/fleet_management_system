<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Driver;

class DriverSeeder extends Seeder
{
    public function run(): void
    {
        $drivers = [
            // Active drivers
            ['name' => 'Juan dela Cruz',       'license_number' => 'N01-23-456789', 'contact' => '09171234567', 'status' => 'active', 'license_expiry_date' => '2027-06-15'],
            ['name' => 'Pedro Santos',         'license_number' => 'N01-23-456790', 'contact' => '09182345678', 'status' => 'active', 'license_expiry_date' => '2026-08-20'],
            ['name' => 'Jose Garcia',          'license_number' => 'N01-23-456791', 'contact' => '09193456789', 'status' => 'active', 'license_expiry_date' => '2027-03-10'],
            ['name' => 'Carlos Villanueva',    'license_number' => 'N01-23-456792', 'contact' => '09204567890', 'status' => 'active', 'license_expiry_date' => '2027-11-25'],
            ['name' => 'Miguel Fernandez',     'license_number' => 'N01-23-456793', 'contact' => '09215678901', 'status' => 'active', 'license_expiry_date' => '2028-01-08'],
            ['name' => 'Antonio Ramos',        'license_number' => 'N01-23-456794', 'contact' => '09226789012', 'status' => 'active', 'license_expiry_date' => '2027-04-17'],
            ['name' => 'Roberto Reyes',        'license_number' => 'N01-23-456795', 'contact' => '09237890123', 'status' => 'active', 'license_expiry_date' => '2026-12-30'],
            ['name' => 'Eduardo Torres',       'license_number' => 'N01-23-456796', 'contact' => '09248901234', 'status' => 'active', 'license_expiry_date' => '2027-09-05'],
            ['name' => 'Francisco Flores',     'license_number' => 'N01-23-456797', 'contact' => '09259012345', 'status' => 'active', 'license_expiry_date' => '2026-05-18'],
            ['name' => 'Renato Mercado',       'license_number' => 'N01-23-456798', 'contact' => '09260123456', 'status' => 'active', 'license_expiry_date' => '2028-02-22'],
            ['name' => 'Danilo Bautista',      'license_number' => 'N01-23-456799', 'contact' => '09171122334', 'status' => 'active', 'license_expiry_date' => '2027-07-11'],
            ['name' => 'Rodrigo Castillo',     'license_number' => 'N01-23-456800', 'contact' => '09182233445', 'status' => 'active', 'license_expiry_date' => '2026-10-09'],
            ['name' => 'Alfredo Navarro',      'license_number' => 'N01-23-456801', 'contact' => '09193344556', 'status' => 'active', 'license_expiry_date' => '2027-01-28'],
            ['name' => 'Bernardo Morales',     'license_number' => 'N01-23-456802', 'contact' => '09204455667', 'status' => 'active', 'license_expiry_date' => '2028-05-14'],
            ['name' => 'Gregorio Aguilar',     'license_number' => 'N01-23-456803', 'contact' => '09215566778', 'status' => 'active', 'license_expiry_date' => '2026-03-07'],

            // Inactive drivers
            ['name' => 'Maria Mendoza',        'license_number' => 'N01-23-456804', 'contact' => '09226677889', 'status' => 'inactive', 'license_expiry_date' => '2025-12-01'],
            ['name' => 'Ana Lourdes Bautista', 'license_number' => 'N01-23-456805', 'contact' => '09237788990', 'status' => 'inactive', 'license_expiry_date' => '2025-09-22'],
            ['name' => 'Rosa Dizon',           'license_number' => 'N01-23-456806', 'contact' => '09248899001', 'status' => 'inactive', 'license_expiry_date' => '2026-05-30'],

            // Expiring soon (within 30 days) — will trigger bell notification
            ['name' => 'Herminio Pascual',     'license_number' => 'N01-23-456807', 'contact' => '09259900112', 'status' => 'active', 'license_expiry_date' => now()->addDays(15)->format('Y-m-d')],
            ['name' => 'Victorino Ocampo',     'license_number' => 'N01-23-456808', 'contact' => '09260011223', 'status' => 'active', 'license_expiry_date' => now()->addDays(7)->format('Y-m-d')],

            // Expired — will trigger error bell notification
            ['name' => 'Simplicio Reyes',      'license_number' => 'N01-23-456809', 'contact' => '09171324568', 'status' => 'active', 'license_expiry_date' => now()->subDays(10)->format('Y-m-d')],
        ];

        foreach ($drivers as $driver) {
            Driver::create($driver);
        }

        $this->command->info('Created ' . count($drivers) . ' drivers successfully.');
    }
}