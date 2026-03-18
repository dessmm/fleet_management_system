@extends('app') 

@section('content')
<h1>Maintenance Records</h1>
<a href="{{ route('maintenance_records.create') }}">Add New Record</a>
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Vehicle</th>
            <th>Issue</th>
            <th>Service Date</th>
            <th>Cost</th>
            <th>Technician Name</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($maintenance_records as $record)
        <tr>
            <td>{{ $record->id }}</td>
            <td>{{ $record->vehicle->plate_number ?? 'N/A' }}</td>
            <td>{{ $record->issue }}</td>
            <td>{{ $record->service_date }}</td>
            <td>{{ $record->cost }}</td>
            <td>{{ $record->technician_name }}</td>
            <td>
                <a href="{{ route('maintenance_records.show', $record->id) }}">View</a> |
                <a href="{{ route('maintenance_records.edit', $record->id) }}">Edit</a> |
                <form action="{{ route('maintenance_records.destroy', $record->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Delete this record?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection