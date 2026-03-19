@extends('app')

@section('content')
<form action="{{ isset($vehicle) ? route('vehicles.update', $vehicle->id) : route('vehicles.store') }}" method="POST">
    @csrf
    @if(isset($vehicle))
        @method('PUT')
    @endif
    <label>Plate Number:</label>
    <input type="text" name="plate_number" value="{{ $vehicle->plate_number ?? '' }}">
    
    <label>Make:</label>
    <input type="text" name="make" value="{{ $vehicle->make ?? '' }}">
    
    <label>Model:</label>
    <input type="text" name="model" value="{{ $vehicle->model ?? '' }}">
    
    <label>Type:</label>
    <input type="text" name="type" value="{{ $vehicle->type ?? '' }}">
    
    <label>Status:</label>
    <input type="text" name="status" value="{{ $vehicle->status ?? 'available' }}">
    
    <label>Capacity:</label>
    <input type="number" name="capacity" value="{{ $vehicle->capacity ?? '' }}">
    
    <button type="submit">Submit</button>
</form>