<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fleet Management System</title>
</head>
<body>
    <header><h1>Fleet Management System</h1></header>    
    <nav>
        <ul>
            <li><a href="{{ route('vehicles.index') }}">Vehicles</a></li>
            <li><a href="{{ route('drivers.index') }}">Drivers</a></li>
            <li><a href="{{ route('trips.index') }}">Trips</a></li>
            <li><a href="{{ route('maintenance_records.index') }}">Maintenance Records</a></li>
            <li><a href="{{ route('fuel_records.index') }}">Fuel Records</a></li>
        </ul>
    </nav>
    <main>
        @yield('content')
    </main>    
</body>
</html>