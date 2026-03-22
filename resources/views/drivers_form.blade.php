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
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79,70,229,.12);
    }
    .fm-field input.is-invalid, .fm-field select.is-invalid { border-color: #dc2626; }
    .fm-field input::placeholder { color: #9ca3af; }
    .action-btn { transition: all .2s ease; }
    .action-btn:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,0,0,.12); }
</style>

<div class="min-h-screen bg-gradient-to-br from-slate-50 via-indigo-50 to-slate-100 px-4 py-8 md:px-8">
    <div class="max-w-7xl mx-auto">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-600 to-indigo-700 flex items-center justify-center shadow-lg shadow-indigo-200 flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 leading-tight">
                        {{ isset($driver) ? 'Edit Driver' : 'Add New Driver' }}
                    </h1>
                    <p class="text-gray-500 text-sm mt-0.5">
                        {{ isset($driver) ? 'Update driver information' : 'Register a new driver to your fleet system' }}
                    </p>
                </div>
            </div>
            <a href="{{ route('drivers.index') }}"
               class="action-btn inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-600 text-sm font-medium rounded-xl shadow-sm hover:bg-gray-50 self-start sm:self-auto">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to roster
            </a>
        </div>

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

            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2 bg-gray-50">
                        <div class="w-6 h-6 rounded-md bg-indigo-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-semibold text-gray-700">Driver Details</span>
                    </div>

                    <form action="{{ isset($driver) ? route('drivers.update', $driver->id) : route('drivers.store') }}"
                          method="POST" class="px-6 py-5 space-y-5">
                        @csrf
                        @if(isset($driver)) @method('PUT') @endif

                        <div class="fm-field">
                            <label for="name" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                Full Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="name" name="name"
                                   class="{{ $errors->has('name') ? 'is-invalid' : '' }}"
                                   placeholder="e.g. John Santos"
                                   value="{{ old('name', $driver->name ?? '') }}" required>
                            @error('name')
                                <p class="mt-1 text-xs text-red-500 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div class="fm-field">
                                <label for="license_number" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                    License Number <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="license_number" name="license_number"
                                       class="{{ $errors->has('license_number') ? 'is-invalid' : '' }}"
                                       placeholder="DL-XXXX-XXXX"
                                       value="{{ old('license_number', $driver->license_number ?? '') }}" required
                                       style="font-family:monospace;text-transform:uppercase;letter-spacing:.04em;">
                                @error('license_number')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="fm-field">
                                <label for="contact" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                    Contact Number <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="contact" name="contact"
                                       class="{{ $errors->has('contact') ? 'is-invalid' : '' }}"
                                       placeholder="e.g. 09xxxxxxxxx"
                                       value="{{ old('contact', $driver->contact ?? '') }}" required>
                                @error('contact')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="fm-field">
                            <label for="license_expiry_date" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                License Expiry Date
                            </label>
                            <input type="date" id="license_expiry_date" name="license_expiry_date"
                                   class="{{ $errors->has('license_expiry_date') ? 'is-invalid' : '' }}"
                                   value="{{ old('license_expiry_date', isset($driver) && $driver->license_expiry_date ? $driver->license_expiry_date->format('Y-m-d') : '') }}">
                            @error('license_expiry_date')
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
                                    <option value="">Select status…</option>
                                    <option value="active"   {{ old('status', $driver->status ?? '') === 'active'   ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status', $driver->status ?? '') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                <svg xmlns="http://www.w3.org/2000/svg" class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                            @error('status')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-2 border-t border-gray-100">
                            <a href="{{ route('drivers.index') }}"
                               class="action-btn px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">
                                Cancel
                            </a>
                            <button type="submit"
                                    class="action-btn inline-flex items-center gap-2 px-5 py-2 text-sm font-semibold text-white bg-gradient-to-r from-indigo-600 to-indigo-700 rounded-xl shadow-md shadow-indigo-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                                {{ isset($driver) ? 'Update Driver' : 'Create Driver' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="space-y-4">

                @if(isset($driver))
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-5 py-3.5 border-b border-gray-100 flex items-center gap-2 bg-gray-50">
                        <div class="w-6 h-6 rounded-md bg-indigo-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-semibold text-gray-700">Current Values</span>
                    </div>
                    <div class="divide-y divide-gray-50 px-5">
                        <div class="py-3">
                            <p class="text-xs text-gray-400 font-medium mb-0.5">Name</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $driver->name }}</p>
                        </div>
                        <div class="py-3">
                            <p class="text-xs text-gray-400 font-medium mb-0.5">License</p>
                            <p class="font-mono text-sm font-bold text-indigo-700">{{ $driver->license_number }}</p>
                        </div>
                        <div class="py-3">
                            <p class="text-xs text-gray-400 font-medium mb-0.5">License Expiry</p>
                            @php $expiry = $driver->license_expiry_date; $expired = $expiry && $expiry->isPast(); @endphp
                            <p class="text-sm font-semibold {{ $expired ? 'text-red-600' : 'text-gray-900' }}">
                                {{ $expiry ? $expiry->format('M d, Y') : 'Not set' }}
                            </p>
                        </div>
                        <div class="py-3">
                            <p class="text-xs text-gray-400 font-medium mb-0.5">Status</p>
                            @if($driver->status === 'active')
                                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 bg-emerald-50 text-emerald-700 text-xs font-semibold rounded-full border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Active
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 bg-red-50 text-red-600 text-xs font-semibold rounded-full border border-red-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>Inactive
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

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
                                'Use the driver\'s full legal name as registered.',
                                'License number must match official records exactly.',
                                'Contact should be a reachable mobile number.',
                                'Set status to Inactive for temporarily unavailable drivers.',
                            ] as $tip)
                            <li class="flex items-start gap-2.5 text-xs text-gray-500">
                                <span class="w-1.5 h-1.5 rounded-full bg-indigo-300 flex-shrink-0 mt-1.5"></span>
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