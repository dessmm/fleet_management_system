@extends('app')

@section('content')
<h1>Add New Maintenance Record</h1>

<form action="{{ route('maintenance_records.store') }}" method="POST">
    @csrf

    <label>Vehicle ID:</label><br>
    <input type="text" name="vehicle_id" required><br><br>

    <label>Maintenance Type:</label><br>
    <input type="text" name="maintenance_type" required><br><br>

    <label>Quantity:</label><br>
    <input type="number" name="quantity" step="0.01" required><br><br>

    <label>Cost:</label><br>
    <input type="number" name="cost" step="0.01" required><br><br>

    <label>Status:</label><br>
    <select name="status">
        <option value="active">Active</option>
        <option value="inactive">Inactive</option>
    </select><br><br>

    <button type="submit">Save Fuel Record</button>
</form>

<br>
<a href="{{ route('fuel_records.index') }}">Back to Fuel Records List</a>
@endsection