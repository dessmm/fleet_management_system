@extends('app')

@section('content')
<style>
    .fm-field input, .fm-field select {
        width: 100%; padding: 9px 12px; font-size: 14px; border: 1px solid #d1d5db; border-radius: 8px;
        background: #fff; color: #111827; outline: none; transition: border-color .15s, box-shadow .15s;
    }
    .fm-field input:focus, .fm-field select:focus { border-color: #dc2626; box-shadow: 0 0 0 3px rgba(220,38,38,.12); }
    .fm-field input.is-invalid, .fm-field select.is-invalid { border-color: #dc2626; }
    .fm-field input::placeholder { color: #9ca3af; }
    .action-btn { transition: all .2s ease; }
    .action-btn:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,0,0,.12); }
    @keyframes fadeIn { from{opacity:0;transform:translateY(8px)} to{opacity:1;transform:translateY(0)} }
    .fade-in { animation: fadeIn .35s ease both; }
</style>

<div class="min-h-screen bg-gradient-to-br from-slate-50 via-red-50 to-slate-100 px-4 py-8 md:px-8">
    <div class="max-w-7xl mx-auto fade-in">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-red-600 to-red-700 flex items-center justify-center shadow-lg shadow-red-200 flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 leading-tight">Add Maintenance Record</h1>
                    <p class="text-gray-500 text-sm mt-0.5">Log service events, repairs, and costs</p>
                </div>
            </div>
            <a href="{{ route('maintenance_records.index') }}"
               class="action-btn inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-600 text-sm font-medium rounded-xl shadow-sm hover:bg-gray-50 self-start sm:self-auto">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to maintenance
            </a>
        </div>

        {{-- Errors --}}
        @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 rounded-xl px-5 py-4 flex items-start gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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

            {{-- ── FORM CARD ── --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                    <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2 bg-gray-50">
                        <div class="w-6 h-6 rounded-md bg-red-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-semibold text-gray-700">Record Details</span>
                    </div>

                    <form action="{{ route('maintenance_records.store') }}" method="POST" class="px-6 py-5 space-y-5">
                        @csrf

                        {{-- Vehicle --}}
                        <div class="fm-field">
                            <label for="vehicle_id" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                Vehicle <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <select id="vehicle_id" name="vehicle_id"
                                        class="{{ $errors->has('vehicle_id') ? 'is-invalid' : '' }}"
                                        style="appearance:none;padding-right:2.5rem;cursor:pointer;" required>
                                    <option value="">Select a vehicle...</option>
                                    @forelse($vehicles as $vehicle)
                                        <option value="{{ $vehicle->id }}" {{ old('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
                                            {{ $vehicle->plate_number }} — {{ $vehicle->make }} {{ $vehicle->model }} ({{ $vehicle->type }})
                                        </option>
                                    @empty
                                        <option disabled>No vehicles available</option>
                                    @endforelse
                                </select>
                                <svg xmlns="http://www.w3.org/2000/svg" class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                            @error('vehicle_id')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>

                        {{-- Issue --}}
                        <div class="fm-field">
                            <label for="issue" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                Issue / Service Type <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="issue" name="issue"
                                   value="{{ old('issue') }}"
                                   class="{{ $errors->has('issue') ? 'is-invalid' : '' }}"
                                   placeholder="e.g. Oil change, brake replacement, tire rotation" required>
                            @error('issue')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>

                        {{-- Service Date + Cost + Technician --}}
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                            <div class="fm-field">
                                <label for="service_date" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                    Service Date <span class="text-red-500">*</span>
                                </label>
                                <input type="date" id="service_date" name="service_date"
                                       value="{{ old('service_date') }}"
                                       class="{{ $errors->has('service_date') ? 'is-invalid' : '' }}" required>
                                @error('service_date')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                            </div>

                            <div class="fm-field">
                                <label for="cost" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                    Cost ($) <span class="text-red-500">*</span>
                                </label>
                                <input type="number" id="cost" name="cost"
                                       value="{{ old('cost') }}"
                                       class="{{ $errors->has('cost') ? 'is-invalid' : '' }}"
                                       step="0.01" min="0" placeholder="0.00" required>
                                @error('cost')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                            </div>

                            <div class="fm-field">
                                <label for="technician_name" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                    Technician <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="technician_name" name="technician_name"
                                       value="{{ old('technician_name') }}"
                                       class="{{ $errors->has('technician_name') ? 'is-invalid' : '' }}"
                                       placeholder="Technician name" required>
                                @error('technician_name')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center justify-end gap-3 pt-2 border-t border-gray-100">
                            <a href="{{ route('maintenance_records.index') }}"
                               class="action-btn px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">
                                Cancel
                            </a>
                            <button type="submit"
                                    class="action-btn inline-flex items-center gap-2 px-5 py-2 text-sm font-semibold text-white bg-gradient-to-r from-red-600 to-red-700 rounded-xl shadow-md shadow-red-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                                Save Record
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- ── SIDEBAR ── --}}
            <div class="space-y-4">

                {{-- Tips --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-5 py-3.5 border-b border-gray-100 flex items-center gap-2 bg-gray-50">
                        <div class="w-6 h-6 rounded-md bg-amber-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-semibold text-gray-700">Tips</span>
                    </div>
                    <div class="px-5 py-4">
                        <ul class="space-y-3">
                            @foreach([
                                'Select the vehicle that was serviced.',
                                'Be specific with the issue — e.g. "Oil Change" not just "Service".',
                                'Enter the actual cost billed including parts and labor.',
                                'Records stay active until you manually mark them as Done.',
                            ] as $tip)
                            <li class="flex items-start gap-2.5 text-xs text-gray-500">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-300 flex-shrink-0 mt-1.5"></span>
                                {{ $tip }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                {{-- Fleet summary --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-5 py-3.5 border-b border-gray-100 flex items-center gap-2 bg-gray-50">
                        <div class="w-6 h-6 rounded-md bg-blue-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 17a2 2 0 104 0 2 2 0 00-4 0m8 0a2 2 0 104 0 2 2 0 00-4 0M3 7h2l2-4h10l2 4h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1V8a1 1 0 011-1z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-semibold text-gray-700">Fleet Summary</span>
                    </div>
                    <div class="divide-y divide-gray-50 px-5">
                        <div class="py-3 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-md bg-blue-100 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 17a2 2 0 104 0 2 2 0 00-4 0m8 0a2 2 0 104 0 2 2 0 00-4 0M3 7h2l2-4h10l2 4h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1V8a1 1 0 011-1z"/>
                                    </svg>
                                </div>
                                <span class="text-xs text-gray-500">Total Vehicles</span>
                            </div>
                            <span class="text-sm font-bold text-gray-900">{{ $vehicles->count() }}</span>
                        </div>
                        <div class="py-3 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-md bg-amber-100 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <span class="text-xs text-gray-500">In Maintenance</span>
                            </div>
                            <span class="text-sm font-bold text-gray-900">{{ $vehicles->where('status', 'in_maintenance')->count() }}</span>
                        </div>
                        <div class="py-3 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-md bg-emerald-100 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <span class="text-xs text-gray-500">Active Vehicles</span>
                            </div>
                            <span class="text-sm font-bold text-gray-900">{{ $vehicles->where('status', 'active')->count() }}</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection