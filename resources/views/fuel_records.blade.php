@extends('app') 

@section('content')
<h1>Fuel Records</h1>
<a href="{{ route('fuel_records.create') }}">Add New Fuel Record</a>
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Vehicle</th>
            <th>Fuel Type</th>
            <th>Quantity</th>
            <th>Cost</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($fuel_records as $record)
        <tr>
            <td>{{ $record->id }}</td>
            <td>{{ $record->vehicle->plate_number ?? 'N/A' }}</td>
            <td>{{ $record->fuel_type }}</td>
            <td>{{ $record->quantity }}</td>
            <td>{{ $record->cost }}</td>
            <td>{{ $record->date }}</td>
            <td>
                <a href="{{ route('fuel_records.show', $record->id) }}">View</a> |
                <a href="{{ route('fuel_records.edit', $record->id) }}">Edit</a> |
                <form action="{{ route('fuel_records.destroy', $record->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Delete this fuel record?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection