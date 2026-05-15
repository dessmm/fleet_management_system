<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\GeminiService;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Models\Trip;
use App\Models\MaintenanceRecord;
use App\Models\FuelRecord;

class ChatController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate(['message' => 'required|string|max:1000']);

        $userMessage = $request->input('message');
        $history     = $request->input('history', []);

        // ── Gather fleet context ──────────────────────────────────
        $context = $this->buildFleetContext();

        // ── Build the shared system prompt ────────────────────────
        $systemPrompt = $this->buildSystemPrompt($context);

        $gemini   = new GeminiService();
        $contents = $gemini->buildContents($history, $userMessage);
        $aiText   = $gemini->generate($systemPrompt, $contents);

        if ($aiText === null) {
            return response()->json([
                'error' => 'AI service unavailable. Please try again.',
            ], 500);
        }


        // ── Parse and execute action if present ───────────────────
        $actionResult = null;
        $displayText  = $aiText;

        if (preg_match('/\[ACTION\](.*?)\[\/ACTION\]/s', $aiText, $matches)) {
            $actionJson   = trim($matches[1]);
            $displayText  = trim(preg_replace('/\[ACTION\].*?\[\/ACTION\]/s', '', $aiText));
            $decoded      = json_decode($actionJson, true);
            if ($decoded) {
                $actionResult = $this->executeAction($decoded);
            }
        }

        return response()->json([
            'reply'         => $displayText,
            'action_result' => $actionResult,
            'provider'      => 'gemini',
        ]);
    }

    // ── Build the shared system prompt ─────────────────────────
    private function buildSystemPrompt(string $context): string
    {
        return "You are FleetBot, a professional AI assistant embedded inside a Fleet Management System built with Laravel. You are helpful, concise, and data-driven.

## YOUR CAPABILITIES:
1. ANSWER questions about the fleet using real-time data provided below
2. PERFORM actions when asked (create/update records)
3. GIVE recommendations and insights based on fleet data

## ACTION FORMAT:
When performing write actions, append this EXACT block at the very END of your message (after your explanation):
[ACTION]{\"type\":\"ACTION_TYPE\",\"data\":{...}}[/ACTION]

Available action types:
- create_vehicle        → data: {plate_number, make, model, type, capacity, status}
- update_vehicle_status → data: {id, status}  (status: active|inactive|in_maintenance)
- create_driver         → data: {name, license_number, contact, status, license_expiry_date}
- update_driver_status  → data: {id, status}  (status: active|inactive)
- create_trip           → data: {vehicle_id, driver_id, start_location, end_location, start_time, status}
- update_trip_status    → data: {id, status}  (status: pending|in_progress|completed)
- create_maintenance    → data: {vehicle_id, issue, service_date, cost, technician_name}
- create_fuel_record    → data: {vehicle_id, fuel_type, quantity, price_per_liter, cost, date, gas_station}

## RESPONSE RULES:
- Be concise and professional
- Use bullet points for lists
- Format currency as PHP X,XXX.XX
- Bold important numbers using **number**
- When asked for a summary, be comprehensive but organized
- If data is not available, say so honestly
- For recommendations, explain your reasoning
- Today's date is " . now()->format('F d, Y') . "
- Current time is " . now()->format('h:i A') . "

## REAL-TIME FLEET DATA:
{$context}";
    }


    // ── Build comprehensive fleet context ─────────────────────────
    private function buildFleetContext(): string
    {
        $vehicles    = Vehicle::all();
        $drivers     = Driver::all();
        $trips       = Trip::with(['vehicle', 'driver'])->latest()->take(20)->get();
        $maintenance = MaintenanceRecord::with('vehicle')->latest()->take(15)->get();
        $fuel        = FuelRecord::with('vehicle')->latest()->take(15)->get();

        // Vehicles
        $ctx  = "### VEHICLES ({$vehicles->count()} total)\n";
        foreach ($vehicles as $v) {
            $ctx .= "- ID:{$v->id} | {$v->make} {$v->model} | Plate:{$v->plate_number} | Type:{$v->type} | Capacity:" . ($v->capacity ? "{$v->capacity}kg" : "N/A") . " | Status:{$v->status}\n";
        }

        // Drivers
        $ctx .= "\n### DRIVERS ({$drivers->count()} total)\n";
        foreach ($drivers as $d) {
            $expiry = $d->license_expiry_date ? $d->license_expiry_date->format('Y-m-d') : 'N/A';
            $expired = $d->license_expiry_date && $d->license_expiry_date->isPast() ? ' [EXPIRED]' : '';
            $expiringSoon = $d->license_expiry_date && !$d->license_expiry_date->isPast() && $d->license_expiry_date->diffInDays(now()) <= 30 ? ' [EXPIRING SOON]' : '';
            $ctx .= "- ID:{$d->id} | {$d->name} | License:{$d->license_number} | Contact:{$d->contact} | Status:{$d->status} | LicenseExpiry:{$expiry}{$expired}{$expiringSoon}\n";
        }

        // Trips
        $ctx .= "\n### TRIPS (latest 20)\n";
        foreach ($trips as $t) {
            $ctx .= "- ID:{$t->id} | {$t->start_location} → {$t->end_location} | Driver:" . ($t->driver->name ?? 'N/A') . " | Vehicle:" . ($t->vehicle->plate_number ?? 'N/A') . " | Status:{$t->status}" . ($t->distance ? " | Distance:{$t->distance}km" : '') . " | Created:{$t->created_at->format('Y-m-d')}\n";
        }

        // Maintenance
        $ctx .= "\n### MAINTENANCE RECORDS (latest 15)\n";
        foreach ($maintenance as $m) {
            $status = $m->completed_at ? "Completed:{$m->completed_at->format('Y-m-d')}" : "Status:In Progress";
            $ctx .= "- ID:{$m->id} | Vehicle:" . ($m->vehicle->plate_number ?? 'N/A') . " | Issue:{$m->issue} | Cost:PHP{$m->cost} | ServiceDate:{$m->service_date->format('Y-m-d')} | Technician:{$m->technician_name} | {$status}\n";
        }

        // Fuel
        $ctx .= "\n### FUEL RECORDS (latest 15)\n";
        foreach ($fuel as $f) {
            $ctx .= "- ID:{$f->id} | Vehicle:" . ($f->vehicle->plate_number ?? 'N/A') . " | Type:{$f->fuel_type} | Qty:{$f->quantity}L | PricePerLiter:PHP" . ($f->price_per_liter ?? 'N/A') . " | TotalCost:PHP{$f->cost} | Station:" . ($f->gas_station ?? 'N/A') . " | Date:{$f->date}\n";
        }

        // Summary stats
        $ctx .= "\n### SUMMARY STATISTICS\n";
        $ctx .= "- Total vehicles: {$vehicles->count()}\n";
        $ctx .= "- Active vehicles: " . $vehicles->where('status', 'active')->count() . "\n";
        $ctx .= "- Inactive vehicles: " . $vehicles->where('status', 'inactive')->count() . "\n";
        $ctx .= "- In maintenance: " . $vehicles->where('status', 'in_maintenance')->count() . "\n";
        $ctx .= "- Total drivers: {$drivers->count()}\n";
        $ctx .= "- Active drivers: " . $drivers->where('status', 'active')->count() . "\n";
        $ctx .= "- Inactive drivers: " . $drivers->where('status', 'inactive')->count() . "\n";
        $ctx .= "- Expired licenses: " . $drivers->filter(fn($d) => $d->license_expiry_date && $d->license_expiry_date->isPast())->count() . "\n";
        $ctx .= "- Licenses expiring within 30 days: " . $drivers->filter(fn($d) => $d->license_expiry_date && !$d->license_expiry_date->isPast() && $d->license_expiry_date->diffInDays(now()) <= 30)->count() . "\n";
        $ctx .= "- Total trips: " . Trip::count() . "\n";
        $ctx .= "- Trips in progress: " . Trip::where('status', 'in_progress')->count() . "\n";
        $ctx .= "- Completed trips: " . Trip::where('status', 'completed')->count() . "\n";
        $ctx .= "- Pending trips: " . Trip::where('status', 'pending')->count() . "\n";
        $ctx .= "- Total maintenance records: " . MaintenanceRecord::count() . "\n";
        $ctx .= "- In-progress maintenance: " . MaintenanceRecord::whereNull('completed_at')->count() . "\n";
        $ctx .= "- Total maintenance cost: PHP " . number_format(MaintenanceRecord::sum('cost'), 2) . "\n";
        $ctx .= "- Total fuel records: " . FuelRecord::count() . "\n";
        $ctx .= "- Total fuel cost: PHP " . number_format(FuelRecord::sum('cost'), 2) . "\n";
        $ctx .= "- Total fuel quantity: " . number_format(FuelRecord::sum('quantity'), 2) . " liters\n";

        return $ctx;
    }

    // ── Execute action returned by the assistant ─────────────────────────
    private function executeAction(array $action): string
    {
        try {
            $type = $action['type'] ?? '';
            $data = $action['data'] ?? [];

            switch ($type) {

                case 'create_vehicle':
                    $vehicle = Vehicle::create([
                        'plate_number' => $data['plate_number'],
                        'make'         => $data['make'],
                        'model'        => $data['model'],
                        'type'         => $data['type'],
                        'capacity'     => $data['capacity'] ?? null,
                        'status'       => $data['status'] ?? 'active',
                    ]);
                    return "✅ Vehicle **{$vehicle->make} {$vehicle->model}** (Plate: {$vehicle->plate_number}) created successfully — ID #{$vehicle->id}";

                case 'update_vehicle_status':
                    $vehicle = Vehicle::findOrFail($data['id']);
                    $vehicle->update(['status' => $data['status']]);
                    return "✅ Vehicle **{$vehicle->plate_number}** status updated to **{$data['status']}**";

                case 'create_driver':
                    $driver = Driver::create([
                        'name'                => $data['name'],
                        'license_number'      => $data['license_number'],
                        'contact'             => $data['contact'],
                        'status'              => $data['status'] ?? 'active',
                        'license_expiry_date' => $data['license_expiry_date'] ?? null,
                    ]);
                    return "✅ Driver **{$driver->name}** created successfully — ID #{$driver->id}";

                case 'update_driver_status':
                    $driver = Driver::findOrFail($data['id']);
                    $driver->update(['status' => $data['status']]);
                    return "✅ Driver **{$driver->name}** status updated to **{$data['status']}**";

                case 'create_trip':
                    $trip = Trip::create([
                        'vehicle_id'     => $data['vehicle_id'],
                        'driver_id'      => $data['driver_id'],
                        'start_location' => $data['start_location'],
                        'end_location'   => $data['end_location'],
                        'start_time'     => $data['start_time'] ?? now(),
                        'status'         => $data['status'] ?? 'pending',
                        'distance'       => $data['distance'] ?? null,
                    ]);
                    return "✅ Trip from **{$trip->start_location}** to **{$trip->end_location}** created — ID #{$trip->id}";

                case 'update_trip_status':
                    $trip   = Trip::findOrFail($data['id']);
                    $update = ['status' => $data['status']];
                    if ($data['status'] === 'in_progress' && !$trip->start_time) $update['start_time'] = now();
                    if ($data['status'] === 'completed') $update['end_time'] = now();
                    $trip->update($update);
                    return "✅ Trip **#{$trip->id}** ({$trip->start_location} → {$trip->end_location}) status updated to **{$data['status']}**";

                case 'create_maintenance':
                    $record = MaintenanceRecord::create([
                        'vehicle_id'      => $data['vehicle_id'],
                        'issue'           => $data['issue'],
                        'service_date'    => $data['service_date'] ?? now()->format('Y-m-d'),
                        'cost'            => $data['cost'] ?? 0,
                        'technician_name' => $data['technician_name'] ?? 'Unknown',
                    ]);
                    Vehicle::find($data['vehicle_id'])?->update(['status' => 'in_maintenance']);
                    return "✅ Maintenance record created for vehicle #{$data['vehicle_id']} — **{$data['issue']}** — ID #{$record->id}. Vehicle set to In Maintenance.";

                case 'create_fuel_record':
                    $record = FuelRecord::create([
                        'vehicle_id'      => $data['vehicle_id'],
                        'fuel_type'       => $data['fuel_type'],
                        'quantity'        => $data['quantity'],
                        'price_per_liter' => $data['price_per_liter'] ?? null,
                        'cost'            => $data['cost'],
                        'date'            => $data['date'] ?? now()->format('Y-m-d'),
                        'gas_station'     => $data['gas_station'] ?? null,
                        'notes'           => $data['notes'] ?? null,
                    ]);
                    return "✅ Fuel record created — **{$data['quantity']}L** of {$data['fuel_type']} for vehicle #{$data['vehicle_id']} — ID #{$record->id}";

                default:
                    return "⚠️ Unknown action type: {$type}";
            }
        } catch (\Exception $e) {
            return "❌ Action failed: " . $e->getMessage();
        }
    }
}