<?php

namespace App\Http\Controllers;

use App\Models\FuelRecord;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class FuelRecordController extends Controller
{
    public function index()
    {
        $fuel_records = FuelRecord::all();
        $vehicles = Vehicle::all();
        return view('fuel_records', compact('fuel_records', 'vehicles'));
    }

    public function create()
    {
        $vehicles = Vehicle::all();
        return view('fuel_records_create', compact('vehicles'));
    }

    public function store(Request $request)
    {
        FuelRecord::create($request->validate([
            'vehicle_id'      => 'required|exists:vehicles,id',
            'fuel_type'       => 'required',
            'quantity'        => 'required|numeric|min:0',
            'price_per_liter' => 'required|numeric|min:0',
            'cost'            => 'required|numeric|min:0',
            'date'            => 'required|date',
            'odometer'        => 'nullable|numeric|min:0',
            'gas_station'     => 'nullable|string|max:255',
            'notes'           => 'nullable|string',
        ]));

        return redirect()->route('fuel_records.index');
    }

    public function show(FuelRecord $fuel_record)
    {
        return view('fuel_records_show', compact('fuel_record'));
    }

    public function edit(FuelRecord $fuel_record)
    {
        $vehicles = Vehicle::all();
        return view('fuel_records_form', compact('fuel_record', 'vehicles'));
    }

    public function update(Request $request, FuelRecord $fuel_record)
    {
        $fuel_record->update($request->validate([
            'vehicle_id'      => 'required|exists:vehicles,id',
            'fuel_type'       => 'required',
            'quantity'        => 'required|numeric|min:0',
            'price_per_liter' => 'required|numeric|min:0',
            'cost'            => 'required|numeric|min:0',
            'date'            => 'required|date',
            'odometer'        => 'nullable|numeric|min:0',
            'gas_station'     => 'nullable|string|max:255',
            'notes'           => 'nullable|string',
        ]));

        return redirect()->route('fuel_records.index');
    }

    public function destroy(FuelRecord $fuel_record)
    {
        $fuel_record->delete();
        return redirect()->route('fuel_records.index');
    }
}