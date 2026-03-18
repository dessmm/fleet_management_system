<?php

namespace App\Http\Controllers;

use App\Models\FuelRecord;
use Illuminate\Http\Request;

class FuelRecordController extends Controller
{
    public function index()
    {
        $fuel_records = FuelRecord::all();
        return view('fuel_records', compact('fuel_records'));
    }

    public function create()
    {
        return view('fuel_records.form');
    }

    public function store(Request $request)
    {
        FuelRecord::create($request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'fuel_type' => 'required',
            'quantity' => 'required|numeric',
            'cost' => 'required|numeric',
            'date' => 'required|date',
        ]));

        return redirect()->route('fuel_records.index');
    }

    public function show(FuelRecord $fuel_record)
    {
        return view('fuel_records.show', compact('fuel_record'));
    }

    public function edit(FuelRecord $fuel_record)
    {
        return view('fuel_records.form', compact('fuel_record'));
    }

    public function update(Request $request, FuelRecord $fuel_record)
    {
        $fuel_record->update($request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'fuel_type' => 'required',
            'quantity' => 'required|numeric',
            'cost' => 'required|numeric',
            'date' => 'required|date',
        ]));

        return redirect()->route('fuel_records.index');
    }

    public function destroy(FuelRecord $fuel_record)
    {
        $fuel_record->delete();
        return redirect()->route('fuel_records.index');
    }
}
