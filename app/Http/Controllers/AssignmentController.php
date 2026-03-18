<?php

namespace App\Http\Controllers;

use App\Models\Assignments;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function index()
    {
        $assignments = Assignments::all();
        return view('assignments.index', compact('assignments'));
    }

    public function create()
    {
        return view('assignments.form');
    }

    public function store(Request $request)
    {
        Assignments::create($request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'driver_id' => 'required|exists:drivers,id',
            'trip_id' => 'required|exists:trips,id',
            'status' => 'required',
        ]));

        return redirect()->route('assignments.index');
    }

    public function show(Assignments $assignment)
    {
        return view('assignments.show', compact('assignment'));
    }

    public function edit(Assignments $assignment)
    {
        return view('assignments.form', compact('assignment'));
    }

    public function update(Request $request, Assignments $assignment)
    {
        $assignment->update($request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'driver_id' => 'required|exists:drivers,id',
            'trip_id' => 'required|exists:trips,id',
            'status' => 'required',
        ]));

        return redirect()->route('assignments.index');
    }

    public function destroy(Assignments $assignment)
    {
        $assignment->delete();
        return redirect()->route('assignments.index');
    }
}
