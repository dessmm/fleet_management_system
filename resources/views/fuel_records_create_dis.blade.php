@extends('app')

@section('content')
<style>
    .fm-field input, .fm-field select {
        width: 100%; padding: 9px 12px; font-size: 14px; border: 1px solid #d1d5db; border-radius: 8px;
        background: #fff; color: #111827; outline: none; transition: border-color .15s, box-shadow .15s;
    }
    .fm-field input:focus, .fm-field select:focus { border-color: #ea580c; box-shadow: 0 0 0 3px rgba(234,88,12,.12); }
    .action-btn { transition: all .2s ease; }
    .action-btn:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,0,0,.12); }
</style>

<div class="min-h-screen bg-gradient-to-br from-slate-50 via-orange-50 to-slate-100 px-4 py-8 md:px-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-orange-600 to-orange-700 flex items-center justify-center shadow-lg shadow-orange-200 flex-shrink-0 text-white text-xl">⛽</div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 leading-tight">Add Fuel Record</h1>
                    <p class="text-gray-500 text-sm mt-0.5">Log fuel refill activity for accurate cost tracking</p>
                </div>
            </div>
            <a href="{{ route('fuel_records.index') }}" class="action-btn inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-600 text-sm font-medium rounded-xl shadow-sm hover:bg-gray-50">Back to fuel records</a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <span class="text-sm font-semibold text-gray-700">Fuel Entry Details</span>
            </div>
            <form action="{{ route('fuel_records.store') }}" method="POST" class="px-6 py-5 space-y-5">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div class="fm-field">
                        <label for="vehicle_id" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Vehicle <span class="text-red-500">*</span></label>
                        <select id="vehicle_id" name="vehicle_id" required>
                            <option value="">Select a vehicle...</option>
                            @forelse($vehicles as $vehicle)
                                <option value="{{ $vehicle->id }}">{{ $vehicle->plate_number }} - {{ $vehicle->make }} {{ $vehicle->model }} ({{ $vehicle->type }})</option>
                            @empty
                                <option disabled>No vehicles available</option>
                            @endforelse
                        </select>
                    </div>
                    <div class="fm-field">
                        <label for="fuel_type" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Fuel Type <span class="text-red-500">*</span></label>
                        <select id="fuel_type" name="fuel_type" required>
                            <option value="">Select fuel type...</option>
                            <option value="Petrol">Petrol</option>
                            <option value="Diesel">Diesel</option>
                            <option value="Electric">Electric</option>
                            <option value="CNG">CNG</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                    <div class="fm-field">
                        <label for="quantity" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Quantity (L) <span class="text-red-500">*</span></label>
                        <input type="number" id="quantity" name="quantity" required step="0.01" min="0" placeholder="50">
                    </div>
                    <div class="fm-field">
                        <label for="cost" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Total Cost <span class="text-red-500">*</span></label>
                        <input type="number" id="cost" name="cost" required step="0.01" min="0" placeholder="0.00">
                    </div>
                    <div class="fm-field">
                        <label for="date" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Date <span class="text-red-500">*</span></label>
                        <input type="date" id="date" name="date" required>
                    </div>
                </div>

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <p class="text-sm text-blue-800"><span class="font-semibold">Tip:</span> Consistent fuel logging improves maintenance planning and route efficiency analysis.</p>
                </div>

                <div class="flex items-center justify-end gap-3 pt-2 border-t border-gray-100">
                    <a href="{{ route('fuel_records.index') }}" class="action-btn px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl">Cancel</a>
                    <button type="submit" class="action-btn inline-flex items-center gap-2 px-5 py-2 text-sm font-semibold text-white bg-gradient-to-r from-orange-600 to-orange-700 rounded-xl shadow-md shadow-orange-200">Save Record</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection