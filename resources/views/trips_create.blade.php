@extends('app')

@section('content')
<style>
    .fm-field input, .fm-field select {
        width: 100%; padding: 9px 12px; font-size: 14px;
        border: 1px solid #d1d5db; border-radius: 8px;
        background: #fff; color: #111827; outline: none;
        transition: border-color .15s, box-shadow .15s;
    }
    .fm-field input:focus, .fm-field select:focus {
        border-color: #7c3aed;
        box-shadow: 0 0 0 3px rgba(124,58,237,.12);
    }
    .fm-field input.is-invalid, .fm-field select.is-invalid { border-color: #dc2626; }
    .fm-field input::placeholder { color: #9ca3af; }
    .action-btn { transition: all .2s ease; }
    .action-btn:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,0,0,.12); }
</style>

<div class="min-h-screen bg-gradient-to-br from-slate-50 via-purple-50 to-slate-100 px-4 py-8 md:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-purple-600 to-purple-700 flex items-center justify-center shadow-lg shadow-purple-200 flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 01.553-.894L9 2m0 18l6-3m-6 3V2m6 15l6-3m-6 3V5m6 9V3m0 0l-6 3m6-3l-6 3m0 0L9 2" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 leading-tight">Create New Trip</h1>
                    <p class="text-gray-500 text-sm mt-0.5">Schedule a new route for your fleet operations</p>
                </div>
            </div>
            <a href="{{ route('trips.index') }}"
               class="action-btn inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-600 text-sm font-medium rounded-xl shadow-sm hover:bg-gray-50 self-start sm:self-auto">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to trips
            </a>
        </div>

        @if ($errors->any())
            <div class="max-w-2xl mb-6 bg-red-50 border border-red-200 rounded-xl px-5 py-4 flex items-start gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <p class="text-sm font-semibold text-red-700 mb-1">Please fix the following errors</p>
                    <ul class="text-sm text-red-600 space-y-0.5 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">//www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span class="text-sm font-semibold text-gray-700">Trip Details</span>
                    </div>

                    <form action="{{ route('trips.store') }}" method="POST" class="px-6 py-5 space-y-5">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div class="fm-field">
                                <label for="vehicle_id" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Vehicle <span class="text-red-500">*</span></label>
                                <select id="vehicle_id" name="vehicle_id" class="{{ $errors->has('vehicle_id') ? 'is-invalid' : '' }}" required>
                                    <option value="">Select a vehicle...</option>
                                    @forelse($vehicles as $vehicle)
                                        <option value="{{ $vehicle->id }}" {{ old('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
                                            {{ $vehicle->plate_number }} - {{ $vehicle->make }} {{ $vehicle->model }}
                                        </option>
                                    @empty
                                        <option disabled>No vehicles available</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="fm-field">
                                <label for="driver_id" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Driver <span class="text-red-500">*</span></label>
                                <select id="driver_id" name="driver_id" class="{{ $errors->has('driver_id') ? 'is-invalid' : '' }}" required>
                                    <option value="">Select a driver...</option>
                                    @forelse($drivers as $driver)
                                        <option value="{{ $driver->id }}" {{ old('driver_id') == $driver->id ? 'selected' : '' }}>
                                            {{ $driver->name }} ({{ $driver->license_number }})
                                        </option>
                                    @empty
                                        <option disabled>No drivers available</option>
                                    @endforelse
                                </select>
                            </div>
                        </div>

                        <div class="fm-field">
                            <label for="start_location" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Start Location <span class="text-red-500">*</span></label>
                            <input type="text" id="start_location" name="start_location" value="{{ old('start_location') }}" class="{{ $errors->has('start_location') ? 'is-invalid' : '' }}" placeholder="123 Main Street, City" required>
                        </div>

                        <div class="fm-field">
                            <label for="end_location" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">End Location <span class="text-red-500">*</span></label>
                            <input type="text" id="end_location" name="end_location" value="{{ old('end_location') }}" class="{{ $errors->has('end_location') ? 'is-invalid' : '' }}" placeholder="456 Destination Ave, City" required>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                            <div class="fm-field sm:col-span-2">
                                <label for="start_time" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Start Time <span class="text-red-500">*</span></label>
                                <input type="datetime-local" id="start_time" name="start_time" value="{{ old('start_time') }}" class="{{ $errors->has('start_time') ? 'is-invalid' : '' }}" required>
                            </div>
                            <div class="fm-field">
                                <label for="distance" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Distance (km)</label>
                                <input type="number" id="distance" name="distance" value="{{ old('distance') }}" step="0.1" class="{{ $errors->has('distance') ? 'is-invalid' : '' }}" placeholder="50">
                            </div>
                        </div>

                        <div class="fm-field">
                            <label for="status" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Status</label>
                            <select id="status" name="status" class="{{ $errors->has('status') ? 'is-invalid' : '' }}">
                                <option value="pending" {{ old('status', 'pending') === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="in_progress" {{ old('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-2 border-t border-gray-100">
                            <a href="{{ route('trips.index') }}" class="action-btn px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">Cancel</a>
                            <button type="submit" class="action-btn inline-flex items-center gap-2 px-5 py-2 text-sm font-semibold text-white bg-gradient-to-r from-purple-600 to-purple-700 rounded-xl shadow-md shadow-purple-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">//www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                                Create Trip
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="space-y-4">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 rounded-lg bg-purple-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-semibold text-gray-700">Tips</span>
                    </div>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-2.5 text-xs text-gray-500"><span class="w-1.5 h-1.5 rounded-full bg-purple-300 flex-shrink-0 mt-1.5"></span>Pick a driver and vehicle that are currently available.</li>
                        <li class="flex items-start gap-2.5 text-xs text-gray-500"><span class="w-1.5 h-1.5 rounded-full bg-purple-300 flex-shrink-0 mt-1.5"></span>Use complete start/end addresses for accurate route tracking.</li>
                        <li class="flex items-start gap-2.5 text-xs text-gray-500"><span class="w-1.5 h-1.5 rounded-full bg-purple-300 flex-shrink-0 mt-1.5"></span>Distance is optional but helpful for fuel and analytics reports.</li>
                        <li class="flex items-start gap-2.5 text-xs text-gray-500"><span class="w-1.5 h-1.5 rounded-full bg-purple-300 flex-shrink-0 mt-1.5"></span>Keep status as Pending until the trip actually starts.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection