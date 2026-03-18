<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::all();
        return view('index', compact('vehicles'));
    }

    public function create()
    {
        return view('form');
    }

    public function store(Request $request)
    {
        Vehicle::create($request->validate([
            'plate_number' => 'required|unique:vehicles',
            'make' => 'required',
            'model' => 'required',
            'type' => 'required',
            'status' => 'required',
            'capacity' => 'nullable|integer',
            'last_maintenance_date' => 'nullable|date',
            'next_maintenance_date' => 'nullable|date',
        ]));

        return redirect()->route('vehicles.index');
    }

    public function show(Vehicle $vehicle)
    {
        return view('show', compact('vehicle'));
    }

    public function edit(Vehicle $vehicle)
    {
        return view('form', compact('vehicle'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $vehicle->update($request->validate([
            'plate_number' => 'required|unique:vehicles,plate_number,' . $vehicle->id,
            'make' => 'required',
            'model' => 'required',
            'type' => 'required',
            'status' => 'required',
            'capacity' => 'nullable|integer',
            'last_maintenance_date' => 'nullable|date',
            'next_maintenance_date' => 'nullable|date',
        ]));

        return redirect()->route('vehicles.index');
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        return redirect()->route('vehicles.index');
    }
}
