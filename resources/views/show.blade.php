@extends('app')

@section('content')
@php
    $vehicleName = trim(($vehicle->make ?? '') . ' ' . ($vehicle->model ?? ''));
    $maintenanceHistory = $vehicle->maintenanceRecords()->latest('service_date')->take(5)->get();
    $activeMaintenances = $vehicle->maintenanceRecords()->whereNull('completed_at')->count();
    $nextDate  = $vehicle->next_maintenance_date;
    $overdue   = $nextDate && $nextDate->isPast();
    $dueSoon   = $nextDate && !$overdue && (int) now()->diffInDays($nextDate) <= 30;
@endphp

<style>
    .info-cell { transition: background .15s; }
    .info-cell:hover { background: #f0f7ff; }
    .action-btn { transition: all .2s ease; }
    .action-btn:hover { transform: translateY(-1px); box-shadow: 0 4px 14px rgba(0,0,0,.12); }
    .side-card { transition: transform .2s ease, box-shadow .2s ease; }
    .side-card:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,.09) !important; }
    @keyframes pulse-dot { 0%,100%{opacity:1;} 50%{opacity:.4;} }
    .pulse { animation: pulse-dot 2s ease-in-out infinite; }
    #del-modal { transition: opacity .2s ease; }
    #del-modal-box { transition: transform .2s ease, opacity .2s ease; }
    @keyframes fadeIn { from{opacity:0;transform:translateY(8px)} to{opacity:1;transform:translateY(0)} }
    .fade-in { animation: fadeIn .35s ease both; }
    .fade-in-2 { animation: fadeIn .35s ease .1s both; }
    .fade-in-3 { animation: fadeIn .35s ease .2s both; }
</style>

<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-slate-100 px-4 py-8 md:px-8">
    <div class="max-w-7xl mx-auto">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8 fade-in">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-600 to-blue-700 flex items-center justify-center shadow-lg shadow-blue-200 flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M3 7a2 2 0 012-2h10a2 2 0 012 2v3H3V7zm-1 5h16v2a2 2 0 01-2 2H4a2 2 0 01-2-2v-2zM6 15a1 1 0 100 2 1 1 0 000-2zm8 0a1 1 0 100 2 1 1 0 000-2z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 leading-tight">Vehicle Details</h1>
                    <p class="text-gray-500 text-sm mt-0.5">View and manage vehicle information</p>
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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

            {{-- ── MAIN CARD ── --}}
            <div class="lg:col-span-2 space-y-5 fade-in-2">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                    {{-- Blue header --}}
                    <div class="relative bg-gradient-to-r from-blue-600 via-blue-700 to-blue-800 px-6 pt-6 pb-16 overflow-hidden">
                        <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full -translate-y-1/2 translate-x-1/4"></div>
                        <div class="absolute bottom-0 right-24 w-32 h-32 bg-white opacity-5 rounded-full translate-y-1/2"></div>
                        <div class="absolute top-4 left-1/2 w-96 h-96 bg-blue-500 opacity-10 rounded-full -translate-x-1/2 -translate-y-1/2 blur-3xl"></div>

                        <div class="relative flex items-start justify-between gap-4">
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-16 rounded-2xl bg-white/20 backdrop-blur flex items-center justify-center flex-shrink-0 border border-white/30 shadow-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 17a2 2 0 104 0 2 2 0 00-4 0m8 0a2 2 0 104 0 2 2 0 00-4 0M3 7h2l2-4h10l2 4h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1V8a1 1 0 011-1z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-xl font-bold text-white">{{ $vehicleName !== '' ? $vehicleName : 'Vehicle' }}</h2>
                                    <div class="flex items-center gap-2 mt-1.5">
                                        <span class="text-blue-200 text-sm">{{ $vehicle->type ?? 'Unknown type' }}</span>
                                        <span class="text-blue-400 text-xs">·</span>
                                        <span class="font-mono text-xs bg-white/20 text-white px-2 py-0.5 rounded-md border border-white/20">
                                            #{{ str_pad($vehicle->id, 3, '0', STR_PAD_LEFT) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            {{-- Status badge in header --}}
                            @if($vehicle->status === 'active')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-400/20 text-emerald-100 text-xs font-semibold rounded-full border border-emerald-300/30 flex-shrink-0">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 pulse"></span>Active
                                </span>
                            @elseif($vehicle->status === 'in_maintenance')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-amber-400/20 text-amber-100 text-xs font-semibold rounded-full border border-amber-300/30 flex-shrink-0">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-400 pulse"></span>In Maintenance
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
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1.5">License Plate</p>
                                <p class="font-mono text-base font-bold text-blue-700 tracking-wider">{{ $vehicle->plate_number }}</p>
                            </div>

                            <div class="info-cell px-5 py-4">
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1.5">Vehicle Type</p>
                                <span class="inline-flex items-center px-2.5 py-1 bg-violet-50 text-violet-700 text-sm font-semibold rounded-lg border border-violet-100">
                                    {{ $vehicle->type ?? 'N/A' }}
                                </span>
                            </div>

                            <div class="info-cell px-5 py-4">
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1.5">Capacity</p>
                                <p class="text-base font-bold text-gray-900">
                                    @if($vehicle->capacity)
                                        {{ number_format($vehicle->capacity) }}&nbsp;<span class="text-sm font-normal text-gray-400">kg</span>
                                    @else
                                        <span class="text-gray-400">—</span>
                                    @endif
                                </p>
                            </div>

                            <div class="info-cell px-5 py-4">
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1.5">Status</p>
                                @if($vehicle->status === 'active')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-50 text-emerald-700 text-sm font-semibold rounded-full border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 pulse"></span>Active
                                    </span>
                                @elseif($vehicle->status === 'in_maintenance')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-amber-50 text-amber-700 text-sm font-semibold rounded-full border border-amber-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 pulse"></span>In Maintenance
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-red-50 text-red-600 text-sm font-semibold rounded-full border border-red-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>Inactive
                                    </span>
                                @endif
                            </div>

                            <div class="info-cell px-5 py-4">
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1.5">Last Maintenance</p>
                                <p class="text-base font-semibold text-gray-900">
                                    {{ $vehicle->last_maintenance_date ? $vehicle->last_maintenance_date->format('M d, Y') : '—' }}
                                </p>
                            </div>

                            <div class="info-cell px-5 py-4">
                                @php
                                    $textColor = $overdue ? 'text-red-600' : ($dueSoon ? 'text-amber-600' : 'text-gray-900');
                                    $subColor  = $overdue ? 'text-red-400' : ($dueSoon ? 'text-amber-400' : 'text-gray-400');
                                @endphp
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1.5">Next Maintenance</p>
                                <p class="text-base font-semibold {{ $textColor }}">
                                    {{ $nextDate ? $nextDate->format('M d, Y') : 'Not scheduled' }}
                                </p>
                                @if($nextDate)
                                    <p class="text-xs mt-0.5 {{ $subColor }}">
                                        {{ $overdue
                                            ? (int) now()->diffInDays($nextDate) . ' days overdue'
                                            : (int) now()->diffInDays($nextDate) . ' days remaining' }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center justify-end gap-2 px-6 py-4 bg-gray-50 border-t border-gray-100 mt-4">
                        <a href="{{ route('vehicles.edit', $vehicle->id) }}"
                           class="action-btn inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-amber-700 bg-amber-50 hover:bg-amber-100 border border-amber-200 rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 11l6.536-6.536a2 2 0 112.828 2.828L11 14H8v-3z"/>
                            </svg>
                            Edit Vehicle
                        </a>
                        <button type="button" onclick="openDelModal()"
                                class="action-btn inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-red-600 bg-red-50 hover:bg-red-100 border border-red-200 rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Delete
                        </button>
                        <form id="del-form" action="{{ route('vehicles.destroy', $vehicle->id) }}" method="POST" class="hidden">
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
                        <div class="w-6 h-6 rounded-md bg-blue-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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
                                <p class="text-sm font-semibold text-gray-900 mt-0.5">{{ $vehicle->created_at->format('M d, Y') }}</p>
                                <p class="text-xs text-gray-400">{{ $vehicle->created_at->format('h:i A') }}</p>
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
                                <p class="text-sm font-semibold text-gray-900 mt-0.5">{{ $vehicle->updated_at->format('M d, Y') }}</p>
                                <p class="text-xs text-gray-400">{{ $vehicle->updated_at->format('h:i A') }}</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 py-3.5">
                            <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-medium">Vehicle ID</p>
                                <p class="font-mono text-sm font-bold text-blue-700 mt-0.5">#{{ str_pad($vehicle->id, 3, '0', STR_PAD_LEFT) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Maintenance History --}}
                <div class="side-card bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-5 py-3.5 border-b border-gray-100 flex items-center justify-between bg-gray-50">
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 rounded-md bg-red-100 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <span class="text-sm font-semibold text-gray-700">Maintenance History</span>
                        </div>
                        @if($activeMaintenances > 0)
                            <span class="px-2 py-0.5 text-xs font-semibold bg-amber-100 text-amber-700 rounded-full">
                                {{ $activeMaintenances }} active
                            </span>
                        @endif
                    </div>
                    @if($maintenanceHistory->isEmpty())
                        <div class="px-5 py-6 text-center">
                            <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z"/>
                                </svg>
                            </div>
                            <p class="text-xs text-gray-400">No maintenance records yet</p>
                        </div>
                    @else
                        <div class="divide-y divide-gray-50">
                            @foreach($maintenanceHistory as $record)
                                <div class="px-5 py-3 hover:bg-gray-50 transition-colors">
                                    <div class="flex items-start justify-between gap-2">
                                        <div class="flex-1 min-w-0">
                                            <p class="text-xs font-semibold text-gray-900 truncate">{{ $record->issue }}</p>
                                            <p class="text-xs text-gray-400 mt-0.5">{{ $record->service_date->format('M d, Y') }} · {{ $record->technician_name }}</p>
                                            <p class="text-xs font-bold text-gray-700 mt-0.5">${{ number_format($record->cost, 2) }}</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            @if($record->completed_at)
                                                <span class="inline-flex items-center px-1.5 py-0.5 bg-emerald-50 text-emerald-700 text-xs font-semibold rounded-full border border-emerald-200">Done</span>
                                            @else
                                                <span class="inline-flex items-center px-1.5 py-0.5 bg-amber-50 text-amber-700 text-xs font-semibold rounded-full border border-amber-200">Active</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="px-5 py-3 border-t border-gray-50">
                            <a href="{{ route('maintenance_records.index') }}?vehicle={{ $vehicle->id }}"
                               class="text-xs text-blue-600 hover:text-blue-800 font-medium inline-flex items-center gap-1">
                                View all maintenance records
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    @endif
                </div>

                {{-- Maintenance Schedule --}}
                <div class="side-card bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-5 py-3.5 border-b border-gray-100 flex items-center gap-2 bg-gray-50">
                        <div class="w-6 h-6 rounded-md bg-amber-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-semibold text-gray-700">Maintenance Schedule</span>
                    </div>
                    <div class="divide-y divide-gray-50 px-5">
                        <div class="flex items-start gap-3 py-3.5">
                            <div class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-medium">Last Service</p>
                                <p class="text-sm font-semibold text-gray-900 mt-0.5">
                                    {{ $vehicle->last_maintenance_date ? $vehicle->last_maintenance_date->format('M d, Y') : '—' }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 py-3.5">
                            @php
                                $iconBg  = $overdue ? 'bg-red-100'   : ($dueSoon ? 'bg-amber-100' : 'bg-gray-100');
                                $iconClr = $overdue ? 'text-red-500' : ($dueSoon ? 'text-amber-500' : 'text-gray-400');
                                $tClr    = $overdue ? 'text-red-600' : ($dueSoon ? 'text-amber-600' : 'text-gray-900');
                                $sClr    = $overdue ? 'text-red-400' : ($dueSoon ? 'text-amber-400' : 'text-gray-400');
                            @endphp
                            <div class="w-8 h-8 rounded-lg {{ $iconBg }} flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 {{ $iconClr }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-medium">Next Service Due</p>
                                <p class="text-sm font-semibold {{ $tClr }} mt-0.5">
                                    {{ $nextDate ? $nextDate->format('M d, Y') : 'Not scheduled' }}
                                </p>
                                @if($nextDate)
                                    <p class="text-xs {{ $sClr }} mt-0.5">
                                        {{ $overdue
                                            ? (int) now()->diffInDays($nextDate) . ' days overdue'
                                            : (int) now()->diffInDays($nextDate) . ' days remaining' }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Progress bar --}}
                    @if($nextDate)
                        @php
                            $lastDate  = $vehicle->last_maintenance_date;
                            $totalSpan = $lastDate ? max(1, $lastDate->diffInDays($nextDate)) : 365;
                            $elapsed   = $lastDate ? min($totalSpan, $lastDate->diffInDays(now())) : $totalSpan;
                            $pct       = min(100, round($elapsed / $totalSpan * 100));
                            $barColor  = $overdue ? 'bg-red-500' : ($dueSoon ? 'bg-amber-500' : 'bg-emerald-500');
                        @endphp
                        <div class="px-5 pb-4">
                            <div class="flex items-center justify-between mb-1.5">
                                <span class="text-xs text-gray-400">Service cycle progress</span>
                                <span class="text-xs font-semibold {{ $tClr }}">{{ $pct }}%</span>
                            </div>
                            <div class="h-2 w-full bg-gray-100 rounded-full overflow-hidden">
                                <div class="{{ $barColor }} h-full rounded-full transition-all duration-700" style="width: {{ $pct }}%"></div>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Quick Actions --}}
                <div class="side-card bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-5 py-3.5 border-b border-gray-100 bg-gray-50">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Quick Actions</p>
                    </div>
                    <div class="p-3 space-y-2">
                        <a href="{{ route('vehicles.edit', $vehicle->id) }}"
                           class="action-btn flex items-center gap-3 px-3 py-2.5 rounded-xl bg-amber-50 hover:bg-amber-100 border border-amber-100 text-amber-700 text-sm font-medium">
                            <div class="w-7 h-7 rounded-lg bg-amber-100 flex items-center justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 11l6.536-6.536a2 2 0 112.828 2.828L11 14H8v-3z"/>
                                </svg>
                            </div>
                            Edit vehicle info
                        </a>
                        <a href="{{ route('vehicles.index') }}"
                           class="action-btn flex items-center gap-3 px-3 py-2.5 rounded-xl bg-blue-50 hover:bg-blue-100 border border-blue-100 text-blue-700 text-sm font-medium">
                            <div class="w-7 h-7 rounded-lg bg-blue-100 flex items-center justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                                </svg>
                            </div>
                            View all vehicles
                        </a>
                        <a href="{{ route('maintenance_records.index') }}?vehicle={{ $vehicle->id }}"
                           class="action-btn flex items-center gap-3 px-3 py-2.5 rounded-xl bg-red-50 hover:bg-red-100 border border-red-100 text-red-600 text-sm font-medium">
                            <div class="w-7 h-7 rounded-lg bg-red-100 flex items-center justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            Maintenance records
                        </a>
                        <button type="button" onclick="openDelModal()"
                                class="action-btn w-full flex items-center gap-3 px-3 py-2.5 rounded-xl bg-gray-50 hover:bg-gray-100 border border-gray-200 text-gray-600 text-sm font-medium">
                            <div class="w-7 h-7 rounded-lg bg-gray-200 flex items-center justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </div>
                            Delete this vehicle
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- Delete Modal --}}
<div id="del-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4"
     style="background: rgba(0,0,0,0.45); backdrop-filter: blur(4px);">
    <div id="del-modal-box" class="bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6 scale-95 opacity-0">
        <div class="w-14 h-14 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
        </div>
        <h3 class="text-lg font-bold text-gray-900 text-center mb-1">Delete Vehicle?</h3>
        <p class="text-sm text-gray-500 text-center mb-6">
            Permanently delete <strong class="text-gray-800">{{ $vehicleName !== '' ? $vehicleName : ('Vehicle #' . str_pad($vehicle->id, 3, '0', STR_PAD_LEFT)) }}</strong>? This action cannot be undone.
        </p>
        <div class="flex gap-3">
            <button onclick="closeDelModal()"
                    class="flex-1 px-4 py-2.5 text-sm font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">
                Cancel
            </button>
            <button onclick="document.getElementById('del-form').submit()"
                    class="flex-1 px-4 py-2.5 text-sm font-semibold text-white bg-red-500 hover:bg-red-600 rounded-xl transition-colors shadow-md shadow-red-200">
                Yes, Delete
            </button>
        </div>
    </div>
</div>

<script>
    function openDelModal() {
        const m = document.getElementById('del-modal');
        const b = document.getElementById('del-modal-box');
        m.classList.remove('hidden');
        m.classList.add('flex');
        setTimeout(() => { b.classList.remove('scale-95','opacity-0'); b.classList.add('scale-100','opacity-100'); }, 10);
    }
    function closeDelModal() {
        const m = document.getElementById('del-modal');
        const b = document.getElementById('del-modal-box');
        b.classList.remove('scale-100','opacity-100');
        b.classList.add('scale-95','opacity-0');
        setTimeout(() => { m.classList.add('hidden'); m.classList.remove('flex'); }, 200);
    }
    document.getElementById('del-modal').addEventListener('click', function(e) {
        if (e.target === this) closeDelModal();
    });
</script>

@endsection