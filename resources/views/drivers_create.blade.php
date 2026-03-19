@extends('app')

@section('content')
<h1>Add New Driver</h1>

<form action="{{ route('drivers.store') }}" method="POST">
    @csrf

    <label>Name:</label><br>
    <input type="text" name="name" required><br><br>

    <label>License Number:</label><br>
    <input type="text" name="license_number" required><br><br>

    <label>Contact:</label><br>
    <input type="text" name="contact" required><br><br>

    <label>Status:</label><br>
    <select name="status">
        <option value="active">Active</option>
        <option value="inactive">Inactive</option>
    </select><br><br>

    <button type="submit">Save Driver</button>
</form>

<br>
<a href="{{ route('drivers.index') }}">Back to Drivers List</a>
@endsection