@extends('app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-red-50 to-slate-100 px-4 py-8 md:px-8">
    <div class="max-w-2xl mx-auto">

        <div class="mb-8 flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-red-600 to-red-700 flex items-center justify-center shadow-lg shadow-red-200 flex-shrink-0 text-white text-xl">🔧</div>
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 leading-tight">
                    {{ isset($maintenance_record) ? 'Edit Record' : 'Add Maintenance Record' }}
                </h1>
                <p class="text-gray-500 text-sm mt-0.5">
                    {{ isset($maintenance_record) ? 'Update the details below' : 'Fill in the details below' }}
                </p>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <span class="text-sm font-semibold text-gray-700">Record Details</span>
            </div>

            <form action="{{ isset($maintenance_record) ? route('maintenance_records.update', $maintenance_record->id) : route('maintenance_records.store') }}" method="POST" class="p-6 space-y-5">
                @csrf
                @if(isset($maintenance_record))
                    @method('PUT')
                @endif

                @if($errors->any())
                    <div class="p-4 bg-red-50 border border-red-200 rounded-xl">
                        <ul class="text-sm text-red-600 space-y-1 list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Vehicle</label>
                    <select name="vehicle_id" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent bg-gray-50">
                        <option value="">Select a vehicle</option>
                        @foreach($vehicles as $vehicle)
                            <option value="{{ $vehicle->id }}" {{ (isset($maintenance_record) && $maintenance_record->vehicle_id == $vehicle->id) || old('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
                                {{ $vehicle->plate_number }} — {{ $vehicle->make }} {{ $vehicle->model }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Issue / Service Type</label>
                    <input type="text" name="issue" value="{{ old('issue', $maintenance_record->issue ?? '') }}"
                        placeholder="e.g. Oil Change, Brake Replacement"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent bg-gray-50">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Service Date</label>
                    <input type="date" name="service_date"
                        value="{{ old('service_date', isset($maintenance_record) ? $maintenance_record->service_date->format('Y-m-d') : '') }}"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent bg-gray-50">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Technician Name</label>
                    <input type="text" name="technician_name" value="{{ old('technician_name', $maintenance_record->technician_name ?? '') }}"
                        placeholder="e.g. Juan Dela Cruz"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent bg-gray-50">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Cost ($)</label>
                    <input type="number" step="0.01" min="0" name="cost" value="{{ old('cost', $maintenance_record->cost ?? '') }}"
                        placeholder="0.00"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent bg-gray-50">
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <a href="{{ route('maintenance_records.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-gray-700 text-sm font-semibold rounded-xl shadow-sm border border-gray-200 hover:bg-gray-50 transition-all duration-200">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-red-600 to-red-700 text-white text-sm font-semibold rounded-xl shadow-md shadow-red-200 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
                        {{ isset($maintenance_record) ? 'Update Record' : 'Save Record' }}
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>
@endsection