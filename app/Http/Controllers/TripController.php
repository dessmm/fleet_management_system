<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class TripController extends Controller
{
    public function index()
    {
        $trips = Trip::all();
        return view('trips_index', compact('trips'));
    }

    public function create()
    {
        $vehicles = \App\Models\Vehicle::all();
        $drivers = \App\Models\Driver::all();
        return view('trips_create', compact('vehicles', 'drivers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'driver_id' => 'required|exists:drivers,id',
            'start_location' => 'required',
            'end_location' => 'required',
            'start_time' => 'required|date_format:Y-m-d\TH:i',
            'end_time' => 'nullable|date_format:Y-m-d\TH:i',
            'distance' => 'nullable|integer',
            'status' => 'required',
        ]);

        // Convert datetime-local format (YYYY-MM-DDTHH:mm) to Y-m-d H:i:s
        if (!empty($validated['start_time'])) {
            $validated['start_time'] = str_replace('T', ' ', $validated['start_time']) . ':00';
        }
        if (!empty($validated['end_time'])) {
            $validated['end_time'] = str_replace('T', ' ', $validated['end_time']) . ':00';
        }

        // Create the trip
        $trip = Trip::create($validated);

        // Update the assigned vehicle status to active
        $vehicle = Vehicle::find($validated['vehicle_id']);
        if ($vehicle) {
            $vehicle->update(['status' => 'active']);
        }

        return redirect()->route('trips.index');
    }

    public function show(Trip $trip)
    {
        return view('trips_show', compact('trip'));
    }

    public function edit(Trip $trip)
    {
        $vehicles = \App\Models\Vehicle::all();
        $drivers = \App\Models\Driver::all();
        return view('trips.form', compact('trip', 'vehicles', 'drivers'));
    }

    public function update(Request $request, Trip $trip)
    {
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'driver_id' => 'required|exists:drivers,id',
            'start_location' => 'required',
            'end_location' => 'required',
            'start_time' => 'required|date_format:Y-m-d\TH:i',
            'end_time' => 'nullable|date_format:Y-m-d\TH:i',
            'distance' => 'nullable|integer',
            'status' => 'required',
        ]);

        // Convert datetime-local format (YYYY-MM-DDTHH:mm) to Y-m-d H:i:s
        if (!empty($validated['start_time'])) {
            $validated['start_time'] = str_replace('T', ' ', $validated['start_time']) . ':00';
        }
        if (!empty($validated['end_time'])) {
            $validated['end_time'] = str_replace('T', ' ', $validated['end_time']) . ':00';
        }

        // Update the trip
        $trip->update($validated);

        // Update the assigned vehicle status to active
        $vehicle = Vehicle::find($validated['vehicle_id']);
        if ($vehicle) {
            $vehicle->update(['status' => 'active']);
        }

        return redirect()->route('trips.index');
    }
    
    public function updateStatus(Request $request, Trip $trip)
{
    $validated = $request->validate([
        'status' => 'required|in:pending,in_progress,completed',
    ]);
 
    $newStatus = $validated['status'];
    $data      = ['status' => $newStatus];
 
    // Auto-set timestamps based on status
    if ($newStatus === 'in_progress' && !$trip->start_time) {
        $data['start_time'] = now();
    }
 
    if ($newStatus === 'completed') {
        $data['end_time'] = now();
    }
 
    // Prevent going backwards (completed → pending etc.)
    $order = ['pending' => 0, 'in_progress' => 1, 'completed' => 2];
    if ($order[$newStatus] < $order[$trip->status]) {
        return back()->with('error', 'Cannot revert a trip to a previous status.');
    }
 
    $trip->update($data);
 
    $messages = [
        'in_progress' => 'Trip has started! Safe travels.',
        'completed'   => 'Trip marked as completed.',
        'pending'     => 'Trip status updated.',
    ];
 
    return back()->with('success', $messages[$newStatus]);
}

    public function destroy(Trip $trip)
    {
        $trip->delete();
        return redirect()->route('trips.index');
    }

    

public function exportPdf(Trip $trip)
{
    $trip->load(['driver', 'vehicle']);

    $trafficCount = 0;
    $routeCount   = 0;
    try { $trafficCount = $trip->trafficData()->whereIn('congestion_level', ['high','severe'])->count(); } catch(\Exception $e) {}
    try { $routeCount = \App\Models\RouteRecommendation::where('trip_id', $trip->id)->where('accepted_by_driver', true)->count(); } catch(\Exception $e) {}

    $pdf = Pdf::loadView('trips_pdf', compact('trip', 'trafficCount', 'routeCount'))
              ->setPaper('a4', 'portrait');

    return $pdf->download('trip-' . str_pad($trip->id, 4, '0', STR_PAD_LEFT) . '.pdf');
}
}
