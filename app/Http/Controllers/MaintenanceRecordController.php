<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MaintenanceRecord;

class MaintenanceRecordController extends Controller
{
    public function index()
    {
        $maintenance_records = MaintenanceRecord::all();
        return view('maintenance_records', compact('maintenance_records'));
    }

    public function create()
    {
        return view('maintenance_create');
    }

    public function store(Request $request)
    {
        MaintenanceRecord::create($request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'issue' => 'required',
            'service_date' => 'required|date',
            'cost' => 'nullable|numeric',
            'technician_name' => 'required',
        ]));

        return redirect()->route('maintenance_create');
    }

    public function show(MaintenanceRecord $maintenance_record)
    {
        return view('maintenance_records.show', compact('maintenance_record'));
    }

    public function edit(MaintenanceRecord $maintenance_record)
    {
        return view('maintenance_records.form', compact('maintenance_record'));
    }

    public function update(Request $request, MaintenanceRecord $maintenance_record){
        $maintenance_record->update($request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'issue' => 'required',
            'service_date' => 'required|date',
            'cost' => 'nullable|numeric',
            'technician_name' => 'required',
        ]));

        return redirect()->route('maintenance_records.index');
    }

    public function destroy(MaintenanceRecord $maintenance_record){
        $maintenance_record->delete();
        return redirect()->route('maintenance_records.index');
    }
}