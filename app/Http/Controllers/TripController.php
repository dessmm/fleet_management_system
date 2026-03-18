<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Http\Request;

class TripController extends Controller
{
    public function index()
    {
        $trips = Trip::all();
        return view('trips_index', compact('trips'));
    }

    public function create()
    {
        return view('trips.form');
    }

    public function store(Request $request)
    {
        Trip::create($request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'driver_id' => 'required|exists:drivers,id',
            'start_location' => 'required',
            'end_location' => 'required',
            'start_time' => 'required|date_format:Y-m-d H:i:s',
            'end_time' => 'nullable|date_format:Y-m-d H:i:s',
            'distance' => 'nullable|integer',
            'status' => 'required',
        ]));

        return redirect()->route('trips.index');
    }

    public function show(Trip $trip)
    {
        return view('trips.show', compact('trip'));
    }

    public function edit(Trip $trip)
    {
        return view('trips.form', compact('trip'));
    }

    public function update(Request $request, Trip $trip)
    {
        $trip->update($request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'driver_id' => 'required|exists:drivers,id',
            'start_location' => 'required',
            'end_location' => 'required',
            'start_time' => 'required|date_format:Y-m-d H:i:s',
            'end_time' => 'nullable|date_format:Y-m-d H:i:s',
            'distance' => 'nullable|integer',
            'status' => 'required',
        ]));

        return redirect()->route('trips.index');
    }

    public function destroy(Trip $trip)
    {
        $trip->delete();
        return redirect()->route('trips.index');
    }
}
