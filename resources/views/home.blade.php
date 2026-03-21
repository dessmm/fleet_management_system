@extends('app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 py-12">
    <div class="container mx-auto px-4">
        
        <div class="mb-16 text-center">
            <div class="inline-block mb-4">
                <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center text-white text-4xl shadow-lg">🚛</div>
            </div>
            <h1 class="text-5xl md:text-6xl font-bold text-gray-900 mb-4">Fleet Management<br><span class="bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">Command Center</span></h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto mb-8">Complete control over your fleet. Manage vehicles, drivers, trips, fuel efficiency, and maintenance all in one unified platform.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('vehicles.index') }}" class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg font-semibold hover:shadow-lg transition-all duration-300 inline-flex items-center justify-center gap-2">
                    <span>🚗</span> View Fleet
                </a>
                <a href="{{ route('traffic.dashboard') }}" class="px-8 py-3 bg-white border-2 border-blue-600 text-blue-600 rounded-lg font-semibold hover:bg-blue-50 transition-all duration-300 inline-flex items-center justify-center gap-2">
                    <span>📍</span> Traffic Control
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-16">
            <a href="{{ route('vehicles.index') }}" class="group bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 p-8 border border-gray-100 hover:border-blue-200 cursor-pointer">
                <div class="text-4xl mb-3">🚗</div>
                <p class="text-gray-600 font-medium mb-1">Vehicles</p>
                <p class="text-3xl font-bold text-gray-900">Manage Fleet</p>
                <div class="h-1 w-12 bg-gradient-to-r from-blue-400 to-blue-600 rounded-full mt-4 group-hover:w-full transition-all duration-300"></div>
            </a>
            <a href="{{ route('drivers.index') }}" class="group bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 p-8 border border-gray-100 hover:border-green-200 cursor-pointer">
                <div class="text-4xl mb-3">👨‍💼</div>
                <p class="text-gray-600 font-medium mb-1">Drivers</p>
                <p class="text-3xl font-bold text-gray-900">Driver List</p>
                <div class="h-1 w-12 bg-gradient-to-r from-green-400 to-green-600 rounded-full mt-4 group-hover:w-full transition-all duration-300"></div>
            </a>
            <a href="{{ route('trips.index') }}" class="group bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 p-8 border border-gray-100 hover:border-purple-200 cursor-pointer">
                <div class="text-4xl mb-3">📍</div>
                <p class="text-gray-600 font-medium mb-1">Trips</p>
                <p class="text-3xl font-bold text-gray-900">Manage Routes</p>
                <div class="h-1 w-12 bg-gradient-to-r from-purple-400 to-purple-600 rounded-full mt-4 group-hover:w-full transition-all duration-300"></div>
            </a>
            <a href="{{ route('fuel_records.index') }}" class="group bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 p-8 border border-gray-100 hover:border-orange-200 cursor-pointer">
                <div class="text-4xl mb-3">⛽</div>
                <p class="text-gray-600 font-medium mb-1">Fuel</p>
                <p class="text-3xl font-bold text-gray-900">Fuel Records</p>
                <div class="h-1 w-12 bg-gradient-to-r from-orange-400 to-orange-600 rounded-full mt-4 group-hover:w-full transition-all duration-300"></div>
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-12 text-center">Key Features</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="text-5xl mb-4">📊</div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Real-Time Analytics</h3>
                    <p class="text-gray-600 text-sm">Monitor fleet performance with live traffic data and intelligent reporting</p>
                </div>
                <div class="text-center">
                    <div class="text-5xl mb-4">🛠️</div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Maintenance Tracking</h3>
                    <p class="text-gray-600 text-sm">Schedule maintenance and keep complete service history for each vehicle</p>
                </div>
                <div class="text-center">
                    <div class="text-5xl mb-4">⛽</div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Fuel Management</h3>
                    <p class="text-gray-600 text-sm">Track fuel consumption and optimize routes for better efficiency</p>
                </div>
                <div class="text-center">
                    <div class="text-5xl mb-4">🚨</div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Alert System</h3>
                    <p class="text-gray-600 text-sm">Get notified about congestion, maintenance due, and fuel levels</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <a href="{{ route('vehicles.create') }}" class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
                <h3 class="text-2xl font-bold mb-2">➕ Add New Vehicle</h3>
                <p class="text-blue-100">Register a new vehicle to your fleet</p>
            </a>
            <a href="{{ route('trips.create') }}" class="bg-gradient-to-br from-purple-500 to-purple-600 text-white rounded-xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
                <h3 class="text-2xl font-bold mb-2">📍 Create New Trip</h3>
                <p class="text-purple-100">Schedule a delivery or route</p>
            </a>
        </div>
    </div>
</div>
@endsection