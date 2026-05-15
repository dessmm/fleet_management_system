<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\FuelRecord;
use App\Models\MaintenanceRecord;
use App\Models\Trip;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class FleetMindController extends Controller
{
    public function index(Request $request)
    {
        $history = $request->session()->get('fleetmind_history', []);
        return view('fleetmind.index', compact('history'));
    }

    public function ask(Request $request)
    {
        $question = trim((string) $request->input('question', ''));
        $answer = $this->handleQuestion($question);

        $history = $request->session()->get('fleetmind_history', []);
        $history[] = [
            'question' => $question,
            'answer' => $answer,
            'at' => now()->toDateTimeString(),
        ];
        $history = array_slice($history, -10);
        $request->session()->put('fleetmind_history', $history);

        return redirect()->route('fleetmind.index');
    }

    private function handleQuestion(string $question): string
    {
        if ($question === '') {
            return "Please enter a fleet-related question (vehicles, drivers, maintenance, fuel, or trips).";
        }

        $q = mb_strtolower($question);

        // Guardrail: fleet topics only
        $isFleetRelated = (bool) preg_match('/\b(vehicle|vehicles|driver|drivers|maintenance|service|fuel|trip|trips|route|routes|license|licence|traffic)\b/i', $question);
        if (!$isFleetRelated) {
            return "I'm here to help with fleet management. Is there anything about your vehicles, drivers, or operations I can help with?";
        }

        // Intent: driver license expiry
        if (str_contains($q, 'license') || str_contains($q, 'licence') || str_contains($q, 'expiry') || str_contains($q, 'expired') || str_contains($q, 'expiring')) {
            return $this->answerLicenseExpiry($q);
        }

        // Intent: fuel cost / spending
        if (str_contains($q, 'fuel') && (str_contains($q, 'spend') || str_contains($q, 'spent') || str_contains($q, 'cost') || str_contains($q, 'total'))) {
            return $this->answerFuelSpend($q);
        }

        // Intent: maintenance due/overdue
        if (str_contains($q, 'maintenance') || str_contains($q, 'service') || str_contains($q, 'overdue') || str_contains($q, 'due')) {
            return $this->answerMaintenance($q);
        }

        // Intent: trip stats/history
        if (str_contains($q, 'trip') || str_contains($q, 'trips') || str_contains($q, 'route') || str_contains($q, 'history')) {
            return $this->answerTrips($q);
        }

        // Intent: fleet summary
        if (str_contains($q, 'summary') || str_contains($q, 'status') || str_contains($q, 'overview') || str_contains($q, 'fleet')) {
            return $this->answerFleetSummary();
        }

        // Fallback
        return "I don't have that data available right now. Please check your records directly.";
    }

    private function answerFleetSummary(): string
    {
        $vehicleTotal = Vehicle::count();
        $vehicleActive = Vehicle::where('status', 'active')->count();
        $vehicleInactive = Vehicle::where('status', 'inactive')->count();

        $driverTotal = Driver::count();
        $driverActive = Driver::where('status', 'active')->count();
        $driverInactive = Driver::where('status', 'inactive')->count();

        return implode("\n", [
            "Fleet summary:",
            "- Vehicles: {$vehicleTotal} total ({$vehicleActive} active, {$vehicleInactive} inactive)",
            "- Drivers: {$driverTotal} total ({$driverActive} active, {$driverInactive} inactive)",
            "",
            "Would you like me to list drivers with expiring licenses or vehicles with recent maintenance?",
        ]);
    }

    private function answerLicenseExpiry(string $q): string
    {
        $days = 30;
        if (preg_match('/\b(\d+)\s*(day|days|d)\b/i', $q, $m)) {
            $days = max(1, min(365, (int) $m[1]));
        }

        $expiredOnly = str_contains($q, 'expired');
        $expiringOnly = str_contains($q, 'expiring') || str_contains($q, 'soon');

        $base = Driver::query()->whereNotNull('license_expiry_date');

        if ($expiredOnly) {
            $drivers = $base->where('license_expiry_date', '<', now()->toDateString())
                ->orderBy('license_expiry_date')
                ->get();
            if ($drivers->isEmpty()) {
                return "No expired driver licenses found.";
            }
            $lines = ["Drivers with expired licenses:"];
            foreach ($drivers as $d) {
                $lines[] = "- {$d->name} — expired {$d->license_expiry_date->format('M d, Y')}";
            }
            $lines[] = "";
            $lines[] = "Would you like me to list licenses expiring in the next {$days} days?";
            return implode("\n", $lines);
        }

        if ($expiringOnly) {
            $drivers = $base->whereBetween('license_expiry_date', [now()->toDateString(), now()->addDays($days)->toDateString()])
                ->orderBy('license_expiry_date')
                ->get();
            if ($drivers->isEmpty()) {
                return "No driver licenses expiring in the next {$days} days.";
            }
            $lines = ["Drivers with licenses expiring in the next {$days} days:"];
            foreach ($drivers as $d) {
                $lines[] = "- {$d->name} — expires {$d->license_expiry_date->format('M d, Y')}";
            }
            $lines[] = "";
            $lines[] = "Would you like me to also list any already-expired licenses?";
            return implode("\n", $lines);
        }

        $expiredCount = (clone $base)->where('license_expiry_date', '<', now()->toDateString())->count();
        $expiringCount = (clone $base)->whereBetween('license_expiry_date', [now()->toDateString(), now()->addDays($days)->toDateString()])->count();
        $unsetCount = Driver::whereNull('license_expiry_date')->count();

        return implode("\n", [
            "Driver license status:",
            "- Expired: {$expiredCount}",
            "- Expiring in next {$days} days: {$expiringCount}",
            "- Expiry date not set: {$unsetCount}",
            "",
            "Would you like me to list the specific drivers in any of these groups?",
        ]);
    }

    private function answerFuelSpend(string $q): string
    {
        $start = null;
        $end = null;

        if (str_contains($q, 'last month')) {
            $start = now()->subMonthNoOverflow()->startOfMonth();
            $end = now()->subMonthNoOverflow()->endOfMonth();
        } elseif (str_contains($q, 'this month')) {
            $start = now()->startOfMonth();
            $end = now()->endOfMonth();
        } elseif (preg_match('/\b(\d{4}-\d{2}-\d{2})\b.*\b(\d{4}-\d{2}-\d{2})\b/', $q, $m)) {
            $start = Carbon::parse($m[1])->startOfDay();
            $end = Carbon::parse($m[2])->endOfDay();
        } else {
            // default: last 30 days
            $start = now()->subDays(30)->startOfDay();
            $end = now()->endOfDay();
        }

        $query = FuelRecord::query()->with('vehicle')
            ->whereBetween('date', [$start->toDateString(), $end->toDateString()]);

        $total = (float) $query->sum('cost');

        $byVehicle = FuelRecord::query()->with('vehicle')
            ->selectRaw('vehicle_id, SUM(cost) as total_cost')
            ->whereBetween('date', [$start->toDateString(), $end->toDateString()])
            ->groupBy('vehicle_id')
            ->orderByDesc('total_cost')
            ->get();

        $range = $start->format('M d, Y') . ' to ' . $end->format('M d, Y');
        if ($total <= 0) {
            return "No fuel spend found for {$range}.";
        }

        $lines = ["Fuel spend for {$range}:", "- Total: $" . number_format($total, 2)];
        if ($byVehicle->count() > 0) {
            $lines[] = "- Breakdown (top " . min(5, $byVehicle->count()) . "):";
            foreach ($byVehicle->take(5) as $row) {
                $plate = optional($row->vehicle)->plate_number ?? 'Unknown vehicle';
                $lines[] = "  - {$plate}: $" . number_format((float) $row->total_cost, 2);
            }
        }
        $lines[] = "";
        $lines[] = "Would you like a full per-vehicle breakdown or a different date range?";
        return implode("\n", $lines);
    }

    private function answerMaintenance(string $q): string
    {
        // This app has maintenance_records with service_date; treat old records as possibly overdue.
        $days = 90;
        if (preg_match('/\b(\d+)\s*(day|days|d)\b/i', $q, $m)) {
            $days = max(1, min(365, (int) $m[1]));
        }

        $cutoff = now()->subDays($days);

        $recent = MaintenanceRecord::query()->with('vehicle')
            ->orderByDesc('service_date')
            ->limit(5)
            ->get();

        $possiblyOverdue = MaintenanceRecord::query()->with('vehicle')
            ->where('service_date', '<=', $cutoff)
            ->orderBy('service_date')
            ->get()
            ->unique('vehicle_id')
            ->values();

        if (str_contains($q, 'overdue')) {
            if ($possiblyOverdue->isEmpty()) {
                return "No vehicles found with a service record older than {$days} days.";
            }
            $lines = ["Vehicles with service older than {$days} days (may be overdue):"];
            foreach ($possiblyOverdue->take(10) as $r) {
                $plate = optional($r->vehicle)->plate_number ?? 'Unknown vehicle';
                $lines[] = "- {$plate} — last serviced " . $r->service_date->format('M d, Y');
            }
            $lines[] = "";
            $lines[] = "Would you like the full list or to change the threshold (e.g., 60 days)?";
            return implode("\n", $lines);
        }

        $lines = ["Maintenance snapshot:"];
        $lines[] = "- Recent service entries (latest " . $recent->count() . "):";
        foreach ($recent as $r) {
            $plate = optional($r->vehicle)->plate_number ?? 'Unknown vehicle';
            $lines[] = "  - {$plate}: {$r->issue} on " . $r->service_date->format('M d, Y');
        }
        $lines[] = "- Vehicles with service older than {$days} days: " . $possiblyOverdue->count();
        $lines[] = "";
        $lines[] = "Would you like me to list the vehicles that may be overdue?";
        return implode("\n", $lines);
    }

    private function answerTrips(string $q): string
    {
        $total = Trip::count();
        $inProgress = Trip::where('status', 'in_progress')->count();
        $pending = Trip::where('status', 'pending')->count();
        $completed = Trip::where('status', 'completed')->count();

        $recent = Trip::query()->with(['vehicle', 'driver'])->orderByDesc('start_time')->limit(5)->get();

        $lines = [
            "Trip summary:",
            "- Total trips: {$total} ({$completed} completed, {$inProgress} in progress, {$pending} pending)",
        ];

        if ($recent->count() > 0) {
            $lines[] = "- Recent trips:";
            foreach ($recent as $t) {
                $plate = optional($t->vehicle)->plate_number ?? 'N/A';
                $driver = optional($t->driver)->name ?? 'Unassigned';
                $lines[] = "  - Trip #{$t->id} ({$plate}, {$driver}) — {$t->start_location} to {$t->end_location}";
            }
        }

        $lines[] = "";
        $lines[] = "Would you like me to list trips for a specific driver or vehicle?";
        return implode("\n", $lines);
    }
}

