@extends('app')

@section('content')

<style>
    .action-btn { transition: all .2s ease; }
    .action-btn:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,0,0,.12); }
    .info-cell { transition: background .15s; }
    .info-cell:hover { background: #f5f3ff; }
    .side-card { transition: transform .2s ease, box-shadow .2s ease; }
    .side-card:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,.09) !important; }
    @keyframes pulse-dot { 0%,100%{opacity:1;} 50%{opacity:.4;} }
    .pulse { animation: pulse-dot 2s ease-in-out infinite; }
    @keyframes fadeIn { from{opacity:0;transform:translateY(8px)} to{opacity:1;transform:translateY(0)} }
    .fade-in   { animation: fadeIn .35s ease both; }
    .fade-in-2 { animation: fadeIn .35s ease .1s both; }
    .fade-in-3 { animation: fadeIn .35s ease .2s both; }
</style>

<div class="min-h-screen bg-gradient-to-br from-slate-50 via-indigo-50 to-slate-100 px-4 py-8 md:px-8">
    <div class="max-w-7xl mx-auto">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8 fade-in">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-600 to-indigo-700 flex items-center justify-center shadow-lg shadow-indigo-200 flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 leading-tight">Driver Profile</h1>
                    <p class="text-gray-500 text-sm mt-0.5">View and manage driver information</p>
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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

            {{-- ── MAIN CARD ── --}}
            <div class="lg:col-span-2 space-y-5 fade-in-2">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                    {{-- Indigo header --}}
                    <div class="relative bg-gradient-to-r from-indigo-600 via-indigo-700 to-indigo-800 px-6 pt-6 pb-16 overflow-hidden">
                        <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full -translate-y-1/2 translate-x-1/4"></div>
                        <div class="absolute bottom-0 right-24 w-32 h-32 bg-white opacity-5 rounded-full translate-y-1/2"></div>
                        <div class="absolute top-4 left-1/2 w-96 h-96 bg-indigo-500 opacity-10 rounded-full -translate-x-1/2 -translate-y-1/2 blur-3xl"></div>

                        @php
                            $initials = collect(explode(' ', $driver->name))->map(fn($w) => strtoupper($w[0] ?? ''))->take(2)->implode('');
                            $licenseExpiry = $driver->license_expiry_date;
                            $licenseExpired = $licenseExpiry && $licenseExpiry->isPast();
                            $licenseExpiringSoon = $licenseExpiry && !$licenseExpired && $licenseExpiry->diffInDays(now()) <= 30;
                        @endphp

                        <div class="relative flex items-start justify-between gap-4">
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-16 rounded-2xl bg-white/20 backdrop-blur flex items-center justify-center flex-shrink-0 border border-white/30 shadow-lg text-white text-2xl font-bold">
                                    {{ $initials }}
                                </div>
                                <div>
                                    <h2 class="text-xl font-bold text-white">{{ $driver->name }}</h2>
                                    <div class="flex items-center gap-2 mt-1.5">
                                        <span class="text-indigo-200 text-sm">Driver</span>
                                        <span class="text-indigo-400 text-xs">·</span>
                                        <span class="font-mono text-xs bg-white/20 text-white px-2 py-0.5 rounded-md border border-white/20">
                                            #{{ str_pad($driver->id, 3, '0', STR_PAD_LEFT) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            @if($driver->status === 'active')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-400/20 text-emerald-100 text-xs font-semibold rounded-full border border-emerald-300/30 flex-shrink-0">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 pulse"></span>Active
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-400/20 text-red-100 text-xs font-semibold rounded-full border border-red-300/30 flex-shrink-0">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>Inactive
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Info grid --}}
                    <div class="relative -mt-8 mx-4 mb-0 bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                        <div class="grid grid-cols-2 divide-x divide-y divide-gray-100">

                            <div class="info-cell px-5 py-4">
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1.5">Full Name</p>
                                <p class="text-base font-bold text-gray-900">{{ $driver->name }}</p>
                            </div>

                            <div class="info-cell px-5 py-4">
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1.5">License Number</p>
                                <p class="font-mono text-base font-bold text-indigo-700 tracking-wider">{{ $driver->license_number }}</p>
                            </div>

                            <div class="info-cell px-5 py-4">
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1.5">Contact</p>
                                <p class="text-base font-semibold text-gray-900">{{ $driver->contact }}</p>
                            </div>

                            <div class="info-cell px-5 py-4">
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1.5">Status</p>
                                @if($driver->status === 'active')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-50 text-emerald-700 text-sm font-semibold rounded-full border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 pulse"></span>Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-red-50 text-red-600 text-sm font-semibold rounded-full border border-red-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>Inactive
                                    </span>
                                @endif
                            </div>

                            <div class="info-cell px-5 py-4 col-span-2">
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1.5">License Expiry</p>
                                @if(!$licenseExpiry)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-gray-50 text-gray-600 text-sm font-semibold rounded-full border border-gray-200">Not set</span>
                                @elseif($licenseExpired)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-red-50 text-red-700 text-sm font-semibold rounded-full border border-red-200">Expired</span>
                                    <p class="text-xs text-red-500 mt-1">{{ $licenseExpiry->format('M d, Y') }}</p>
                                @elseif($licenseExpiringSoon)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-amber-50 text-amber-700 text-sm font-semibold rounded-full border border-amber-200">Expires soon</span>
                                    <p class="text-xs text-amber-500 mt-1">{{ $licenseExpiry->format('M d, Y') }}</p>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-50 text-emerald-700 text-sm font-semibold rounded-full border border-emerald-200">Valid</span>
                                    <p class="text-xs text-emerald-500 mt-1">Until {{ $licenseExpiry->format('M d, Y') }}</p>
                                @endif
                            </div>

                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center justify-end gap-2 px-6 py-4 bg-gray-50 border-t border-gray-100 mt-4">
                        <a href="{{ route('drivers.edit', $driver->id) }}"
                           class="action-btn inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-amber-700 bg-amber-50 hover:bg-amber-100 border border-amber-200 rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 11l6.536-6.536a2 2 0 112.828 2.828L11 14H8v-3z"/>
                            </svg>
                            Edit Driver
                        </a>
                        <button type="button" onclick="openDelModal()"
                                class="action-btn inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-red-600 bg-red-50 hover:bg-red-100 border border-red-200 rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Delete
                        </button>
                        <form id="del-form" action="{{ route('drivers.destroy', $driver->id) }}" method="POST" class="hidden">
                            @csrf @method('DELETE')
                        </form>
                    </div>
                </div>
            </div>

            {{-- ── SIDEBAR ── --}}
            <div class="space-y-4 fade-in-3">

                {{-- Record Info --}}
                <div class="side-card bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-5 py-3.5 border-b border-gray-100 flex items-center gap-2 bg-gray-50">
                        <div class="w-6 h-6 rounded-md bg-indigo-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-semibold text-gray-700">Record Info</span>
                    </div>
                    <div class="divide-y divide-gray-50 px-5">
                        <div class="flex items-start gap-3 py-3.5">
                            <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-medium">Date Added</p>
                                <p class="text-sm font-semibold text-gray-900 mt-0.5">{{ $driver->created_at->format('M d, Y') }}</p>
                                <p class="text-xs text-gray-400">{{ $driver->created_at->format('h:i A') }}</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 py-3.5">
                            <div class="w-8 h-8 rounded-lg bg-violet-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-violet-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 11l6.536-6.536a2 2 0 112.828 2.828L11 14H8v-3z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-medium">Last Updated</p>
                                <p class="text-sm font-semibold text-gray-900 mt-0.5">{{ $driver->updated_at->format('M d, Y') }}</p>
                                <p class="text-xs text-gray-400">{{ $driver->updated_at->format('h:i A') }}</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 py-3.5">
                            <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-medium">Driver ID</p>
                                <p class="font-mono text-sm font-bold text-indigo-700 mt-0.5">#{{ str_pad($driver->id, 3, '0', STR_PAD_LEFT) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- License Info --}}
                <div class="side-card bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-5 py-3.5 border-b border-gray-100 flex items-center gap-2 bg-gray-50">
                        <div class="w-6 h-6 rounded-md bg-amber-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                            </svg>
                        </div>
                        <span class="text-sm font-semibold text-gray-700">License Info</span>
                    </div>
                    <div class="divide-y divide-gray-50 px-5">
                        <div class="flex items-start gap-3 py-3.5">
                            <div class="w-8 h-8 rounded-lg bg-indigo-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-medium">License Number</p>
                                <p class="font-mono text-sm font-bold text-indigo-700 mt-0.5">{{ $driver->license_number }}</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 py-3.5">
                            @php
                                $iconBg  = $licenseExpired ? 'bg-red-100'   : ($licenseExpiringSoon ? 'bg-amber-100' : 'bg-emerald-100');
                                $iconClr = $licenseExpired ? 'text-red-500' : ($licenseExpiringSoon ? 'text-amber-500' : 'text-emerald-600');
                                $tClr    = $licenseExpired ? 'text-red-600' : ($licenseExpiringSoon ? 'text-amber-600' : 'text-gray-900');
                            @endphp
                            <div class="w-8 h-8 rounded-lg {{ $iconBg }} flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 {{ $iconClr }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-medium">Expiry Date</p>
                                <p class="text-sm font-semibold {{ $tClr }} mt-0.5">
                                    {{ $licenseExpiry ? $licenseExpiry->format('M d, Y') : 'Not set' }}
                                </p>
                                @if($licenseExpiry)
                                    <p class="text-xs mt-0.5 {{ $iconClr }}">
                                        {{ $licenseExpired ? (int) now()->diffInDays($licenseExpiry) . ' days overdue' : (int) now()->diffInDays($licenseExpiry) . ' days remaining' }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Quick Actions --}}
                <div class="side-card bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-5 py-3.5 border-b border-gray-100 bg-gray-50">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Quick Actions</p>
                    </div>
                    <div class="p-3 space-y-2">
                        <a href="{{ route('drivers.edit', $driver->id) }}"
                           class="action-btn flex items-center gap-3 px-3 py-2.5 rounded-xl bg-amber-50 hover:bg-amber-100 border border-amber-100 text-amber-700 text-sm font-medium">
                            <div class="w-7 h-7 rounded-lg bg-amber-100 flex items-center justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 11l6.536-6.536a2 2 0 112.828 2.828L11 14H8v-3z"/>
                                </svg>
                            </div>
                            Edit driver info
                        </a>
                        <a href="{{ route('drivers.index') }}"
                           class="action-btn flex items-center gap-3 px-3 py-2.5 rounded-xl bg-indigo-50 hover:bg-indigo-100 border border-indigo-100 text-indigo-700 text-sm font-medium">
                            <div class="w-7 h-7 rounded-lg bg-indigo-100 flex items-center justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            View all drivers
                        </a>
                        <a href="{{ route('trips.index') }}"
                           class="action-btn flex items-center gap-3 px-3 py-2.5 rounded-xl bg-purple-50 hover:bg-purple-100 border border-purple-100 text-purple-700 text-sm font-medium">
                            <div class="w-7 h-7 rounded-lg bg-purple-100 flex items-center justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 01.553-.894L9 2m0 18l6-3m-6 3V2m6 15l6-3m-6 3V5m6 9V3m0 0l-6 3m6-3l-6 3"/>
                                </svg>
                            </div>
                            View trips
                        </a>
                        <button type="button" onclick="openDelModal()"
                                class="action-btn w-full flex items-center gap-3 px-3 py-2.5 rounded-xl bg-gray-50 hover:bg-gray-100 border border-gray-200 text-gray-600 text-sm font-medium">
                            <div class="w-7 h-7 rounded-lg bg-gray-200 flex items-center justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </div>
                            Delete this driver
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- Delete Modal --}}
<div id="del-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4"
     style="background:rgba(0,0,0,.45);backdrop-filter:blur(4px)">
    <div id="del-box" class="bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6 scale-95 opacity-0 transition-all duration-200">
        <div class="w-14 h-14 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
        </div>
        <h3 class="text-lg font-bold text-gray-900 text-center mb-1">Delete Driver?</h3>
        <p class="text-sm text-gray-500 text-center mb-6">Permanently remove <strong class="text-gray-800">{{ $driver->name }}</strong>? This cannot be undone.</p>
        <div class="flex gap-3">
            <button onclick="closeDelModal()" class="flex-1 px-4 py-2.5 text-sm font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">Cancel</button>
            <button onclick="document.getElementById('del-form').submit()" class="flex-1 px-4 py-2.5 text-sm font-semibold text-white bg-red-500 hover:bg-red-600 rounded-xl transition-colors shadow-md shadow-red-200">Yes, Delete</button>
        </div>
    </div>
</div>

<script>
    function openDelModal() {
        const m = document.getElementById('del-modal'), b = document.getElementById('del-box');
        m.classList.remove('hidden'); m.classList.add('flex');
        setTimeout(() => { b.classList.remove('scale-95','opacity-0'); b.classList.add('scale-100','opacity-100'); }, 10);
    }
    function closeDelModal() {
        const m = document.getElementById('del-modal'), b = document.getElementById('del-box');
        b.classList.remove('scale-100','opacity-100'); b.classList.add('scale-95','opacity-0');
        setTimeout(() => { m.classList.add('hidden'); m.classList.remove('flex'); }, 200);
    }
    document.getElementById('del-modal').addEventListener('click', e => { if (e.target === document.getElementById('del-modal')) closeDelModal(); });
</script>

@endsection