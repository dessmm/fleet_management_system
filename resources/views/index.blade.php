@extends('app')

@section('content')
    <h2>Vehicle List</h2>
    <a href="{{ route('vehicles.create') }}">Add New Vehicle</a>
    <table border=1 cellpadding=5 cellspacing=0>
        <thead>
            <tr>
                <th>Make</th>
                <th>Model</th>
                <th>Year</th>
                <th>License Plate</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($vehicles as $vehicle)
                <tr>
                    <td>{{ $vehicle->make }}</td>
                    <td>{{ $vehicle->model }}</td>
                    <td>{{ $vehicle->year }}</td>
                    <td>{{ $vehicle->license_plate }}</td>
                    <td>{{ $vehicle->status }}</td>
                    <td>
                        <a href="{{ route('vehicles.show', $vehicle->id) }}">View</a>
                        <a href="{{ route('vehicles.edit', $vehicle->id) }}">Edit</a>
                        <form action="{{ route('vehicles.destroy', $vehicle->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection