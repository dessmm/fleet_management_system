@extends('app') 
@section('content')
<h1>Drivers List</h1>


<a href="{{ route('drivers.create') }}">Add New Driver</a>


<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>License Number</th>
            <th>Contact</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($drivers as $driver)
        <tr>
            <td>{{ $driver->id }}</td>
            <td>{{ $driver->name }}</td>
            <td>{{ $driver->license_number }}</td>
            <td>{{ $driver->contact }}</td>
            <td>{{ $driver->status }}</td>
            <td>
                <a href="{{ route('drivers.show', $driver->id) }}">View</a> |
                <a href="{{ route('drivers.edit', $driver->id) }}">Edit</a> |
                <form action="{{ route('drivers.destroy', $driver->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Delete this driver?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection