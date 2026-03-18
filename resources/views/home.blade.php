@extends('app')

@section('content')
<h1>Welcome to Fleet Management System</h1>
<p>Manage vehicles, drivers, trips, fuel, and maintenance all in one place.</p>
<a href="{{ route('vehicles.index') }}">View Vehicles</a>
@endsection