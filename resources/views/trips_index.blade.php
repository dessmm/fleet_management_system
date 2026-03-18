@extends('app') 

@section('content')
<h1>Trips List</h1>

<a href="{{ route('trips.create') }}">Add New Trip</a>

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Vehicle</th>
            <th>Driver</th>
            <th>Start Location</th>
            <th>End Location</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Distance</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($trips as $trip)
        <tr>
            <td>{{ $trip->id }}</td>
            <td>{{ $trip->vehicle->plate_number ?? 'N/A' }}</td>
            <td>{{ $trip->driver->name ?? 'N/A' }}</td>
            <td>{{ $trip->start_location }}</td>
            <td>{{ $trip->end_location }}</td>
            <td>{{ $trip->start_time }}</td>
            <td>{{ $trip->end_time }}</td>
            <td>{{ $trip->distance }}</td>
            <td>{{ $trip->status }}</td>
            <td>
                <a href="{{ route('trips.show', $trip->id) }}">View</a> |
                <a href="{{ route('trips.edit', $trip->id) }}">Edit</a> |
                <form action="{{ route('trips.destroy', $trip->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Delete this trip?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection