<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MaintenanceRecord;
use App\Models\Vehicle;
use Barryvdh\DomPDF\Facade\Pdf;

class MaintenanceRecordController extends Controller
{
    public function index()
    {
        $maintenance_records = MaintenanceRecord::with('vehicle')->latest()->get();
        return view('maintenance_records', compact('maintenance_records'));
    }

    public function create()
    {
        $vehicles = Vehicle::all();
        return view('maintenance_create', compact('vehicles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'vehicle_id'      => 'required|exists:vehicles,id',
            'issue'           => 'required',
            'service_date'    => 'required|date',
            'cost'            => 'nullable|numeric',
            'technician_name' => 'required',
        ]);

        MaintenanceRecord::create($validated);

        // Auto-set vehicle to in_maintenance
        Vehicle::find($validated['vehicle_id'])
            ?->update(['status' => 'in_maintenance']);

        return redirect()->route('maintenance_records.index')
                         ->with('success', 'Maintenance record added. Vehicle marked as In Maintenance.');
    }

    public function show(MaintenanceRecord $maintenance_record)
    {
        $maintenance_record->load('vehicle');
        return view('maintenance_show', compact('maintenance_record'));
    }

    public function edit(MaintenanceRecord $maintenance_record)
    {
        $vehicles = Vehicle::all();
        return view('maintenance_form', compact('maintenance_record', 'vehicles'));
    }

    public function update(Request $request, MaintenanceRecord $maintenance_record)
    {
        $maintenance_record->update($request->validate([
            'vehicle_id'      => 'required|exists:vehicles,id',
            'issue'           => 'required',
            'service_date'    => 'required|date',
            'cost'            => 'nullable|numeric',
            'technician_name' => 'required',
        ]));

        return redirect()->route('maintenance_records.index')
                         ->with('success', 'Maintenance record updated.');
    }

    public function markComplete(MaintenanceRecord $maintenance_record)
    {
        $maintenance_record->update(['completed_at' => now()]);

        // Check if vehicle has any other incomplete maintenance records
        $hasIncomplete = MaintenanceRecord::where('vehicle_id', $maintenance_record->vehicle_id)
            ->whereNull('completed_at')
            ->where('id', '!=', $maintenance_record->id)
            ->exists();

        // If no more incomplete records, restore vehicle to active
        if (!$hasIncomplete) {
            Vehicle::find($maintenance_record->vehicle_id)
                ?->update(['status' => 'active']);
        }

        return back()->with('success', 'Maintenance marked as completed. Vehicle restored to Active.');
    }

    public function destroy(MaintenanceRecord $maintenance_record)
    {
        $vehicleId = $maintenance_record->vehicle_id;
        $maintenance_record->delete();

        // If no more incomplete records, restore vehicle to active
        $hasIncomplete = MaintenanceRecord::where('vehicle_id', $vehicleId)
            ->whereNull('completed_at')
            ->exists();

        if (!$hasIncomplete) {
            Vehicle::find($vehicleId)?->update(['status' => 'active']);
        }

        return redirect()->route('maintenance_records.index')
                         ->with('success', 'Maintenance record deleted.');
    }

    public function exportPdf(MaintenanceRecord $maintenance_record)
    {
        $maintenance_record->load('vehicle');
        $pdf = Pdf::loadView('maintenance_pdf', compact('maintenance_record'))
                  ->setPaper('a4', 'portrait');
        return $pdf->download('maintenance-' . str_pad($maintenance_record->id, 4, '0', STR_PAD_LEFT) . '.pdf');
    }
}