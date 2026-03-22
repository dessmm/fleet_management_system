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
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37,99,235,.12);
    }
    .fm-field input.is-invalid, .fm-field select.is-invalid { border-color: #dc2626; }
    .fm-field input::placeholder { color: #9ca3af; }
    .action-btn { transition: all .2s ease; }
    .action-btn:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,0,0,.12); }
    @keyframes fadeIn { from{opacity:0;transform:translateY(8px)} to{opacity:1;transform:translateY(0)} }
    .fade-in { animation: fadeIn .35s ease both; }
</style>

<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-slate-100 px-4 py-8 md:px-8">
    <div class="max-w-7xl mx-auto fade-in">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-600 to-blue-700 flex items-center justify-center shadow-lg shadow-blue-200 flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 leading-tight">
                        {{ isset($vehicle) ? 'Edit Vehicle' : 'Add New Vehicle' }}
                    </h1>
                    <p class="text-gray-500 text-sm mt-0.5">
                        {{ isset($vehicle) ? 'Update vehicle information' : 'Register a new vehicle to your fleet' }}
                    </p>
                </div>
            </div>
            <a href="{{ route('vehicles.index') }}"
               class="action-btn inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-600 text-sm font-medium rounded-xl shadow-sm hover:bg-gray-50 self-start sm:self-auto">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to fleet
            </a>
        </div>

        {{-- Errors --}}
        @if ($errors->any())
        <div class="max-w-2xl mb-6 bg-red-50 border border-red-200 rounded-xl px-5 py-4 flex items-start gap-3">
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
                        <div class="w-6 h-6 rounded-md bg-blue-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-semibold text-gray-700">Vehicle Details</span>
                    </div>

                    <form action="{{ isset($vehicle) ? route('vehicles.update', $vehicle->id) : route('vehicles.store') }}" method="POST" class="px-6 py-5 space-y-5">
                        @csrf
                        @if(isset($vehicle)) @method('PUT') @endif

                        {{-- License Plate + Type --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div class="fm-field">
                                <label for="plate_number" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                    License Plate <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="plate_number" name="plate_number"
                                    class="{{ $errors->has('plate_number') ? 'is-invalid' : '' }}"
                                    placeholder="ABC-1234"
                                    value="{{ old('plate_number', $vehicle->plate_number ?? '') }}"
                                    style="font-family:monospace;text-transform:uppercase;letter-spacing:.06em;"
                                    required>
                                @error('plate_number')
                                    <p class="mt-1 text-xs text-red-500 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="fm-field">
                                <label for="type" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                    Vehicle Type <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="type" name="type"
                                    class="{{ $errors->has('type') ? 'is-invalid' : '' }}"
                                    placeholder="e.g. Van, Truck, Sedan"
                                    value="{{ old('type', $vehicle->type ?? '') }}" required>
                                @error('type')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Make + Model --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div class="fm-field">
                                <label for="make" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                    Make <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="make" name="make"
                                    class="{{ $errors->has('make') ? 'is-invalid' : '' }}"
                                    placeholder="e.g. Toyota, Ford"
                                    value="{{ old('make', $vehicle->make ?? '') }}" required>
                                @error('make')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="fm-field">
                                <label for="model" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                    Model <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="model" name="model"
                                    class="{{ $errors->has('model') ? 'is-invalid' : '' }}"
                                    placeholder="e.g. HiAce, F-150"
                                    value="{{ old('model', $vehicle->model ?? '') }}" required>
                                @error('model')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Capacity + Status --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div class="fm-field">
                                <label for="capacity" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                    Capacity (kg)
                                </label>
                                <input type="number" id="capacity" name="capacity"
                                    class="{{ $errors->has('capacity') ? 'is-invalid' : '' }}"
                                    placeholder="1500"
                                    value="{{ old('capacity', $vehicle->capacity ?? '') }}">
                                <p class="mt-1 text-xs text-gray-400">Leave blank if not applicable</p>
                                @error('capacity')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="fm-field">
                                <label for="status" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                    Status <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <select id="status" name="status"
                                            class="{{ $errors->has('status') ? 'is-invalid' : '' }}"
                                            style="appearance:none;padding-right:2.5rem;cursor:pointer;" required>
                                        <option value="">Select status</option>
                                        <option value="active"         {{ old('status', $vehicle->status ?? '') === 'active'         ? 'selected' : '' }}>Active</option>
                                        <option value="in_maintenance" {{ old('status', $vehicle->status ?? '') === 'in_maintenance' ? 'selected' : '' }}>In Maintenance</option>
                                        <option value="inactive"       {{ old('status', $vehicle->status ?? '') === 'inactive'       ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                                @error('status')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center justify-end gap-3 pt-2 border-t border-gray-100">
                            <a href="{{ route('vehicles.index') }}"
                               class="action-btn px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">
                                Cancel
                            </a>
                            <button type="submit"
                                    class="action-btn inline-flex items-center gap-2 px-5 py-2 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl shadow-md shadow-blue-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                                {{ isset($vehicle) ? 'Update Vehicle' : 'Create Vehicle' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- ── SIDEBAR ── --}}
            <div class="space-y-4">

                {{-- Current Values (edit mode only) --}}
                @if(isset($vehicle))
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-5 py-3.5 border-b border-gray-100 flex items-center gap-2 bg-gray-50">
                        <div class="w-6 h-6 rounded-md bg-blue-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-semibold text-gray-700">Current Values</span>
                    </div>
                    <div class="divide-y divide-gray-50 px-5">
                        <div class="py-3 flex items-center gap-3">
                            <div class="w-7 h-7 rounded-lg bg-gray-100 flex items-center justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-medium">Make</p>
                                <p class="text-sm font-semibold text-gray-900">{{ $vehicle->make }}</p>
                            </div>
                        </div>
                        <div class="py-3 flex items-center gap-3">
                            <div class="w-7 h-7 rounded-lg bg-gray-100 flex items-center justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-medium">Model</p>
                                <p class="text-sm font-semibold text-gray-900">{{ $vehicle->model }}</p>
                            </div>
                        </div>
                        <div class="py-3 flex items-center gap-3">
                            <div class="w-7 h-7 rounded-lg bg-blue-100 flex items-center justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-medium">License Plate</p>
                                <p class="font-mono text-sm font-bold text-blue-700 tracking-wider">{{ $vehicle->plate_number }}</p>
                            </div>
                        </div>
                        <div class="py-3 flex items-center gap-3">
                            <div class="w-7 h-7 rounded-lg bg-violet-100 flex items-center justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-violet-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-medium">Capacity</p>
                                <p class="text-sm font-semibold text-gray-900">{{ number_format($vehicle->capacity ?? 0) }} kg</p>
                            </div>
                        </div>
                        <div class="py-3 flex items-center gap-3">
                            <div class="w-7 h-7 rounded-lg bg-gray-100 flex items-center justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-medium">Status</p>
                                @if($vehicle->status === 'active')
                                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 bg-emerald-50 text-emerald-700 text-xs font-semibold rounded-full border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Active
                                    </span>
                                @elseif($vehicle->status === 'in_maintenance')
                                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 bg-amber-50 text-amber-700 text-xs font-semibold rounded-full border border-amber-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>In Maintenance
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 bg-red-50 text-red-600 text-xs font-semibold rounded-full border border-red-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>Inactive
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endif

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
                                'Use a consistent naming format, e.g. brand + model.',
                                'License plate must match official registration exactly.',
                                'Use In Maintenance for vehicles currently being serviced.',
                                'Capacity is the maximum cargo weight in kilograms.',
                            ] as $tip)
                            <li class="flex items-start gap-2.5 text-xs text-gray-500">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-300 flex-shrink-0 mt-1.5"></span>
                                {{ $tip }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection