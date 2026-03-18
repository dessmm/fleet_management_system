<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function index()
    {
        $drivers = Driver::all();
        return view('drivers_index', compact('drivers'));
    }

    public function create()
    {
        return view('drivers.form');
    }

    public function store(Request $request)
    {
        Driver::create($request->validate([
            'name' => 'required',
            'license_number' => 'required|unique:drivers',
            'contact' => 'required',
            'status' => 'required',
        ]));

        return redirect()->route('drivers.index');
    }

    public function show(Driver $driver)
    {
        return view('drivers.show', compact('driver'));
    }

    public function edit(Driver $driver)
    {
        return view('drivers.form', compact('driver'));
    }

    public function update(Request $request, Driver $driver)
    {
        $driver->update($request->validate([
            'name' => 'required',
            'license_number' => 'required|unique:drivers,license_number,' . $driver->id,
            'contact' => 'required',
            'status' => 'required',
        ]));

        return redirect()->route('drivers.index');
    }

    public function destroy(Driver $driver)
    {
        $driver->delete();
        return redirect()->route('drivers.index');
    }
}
