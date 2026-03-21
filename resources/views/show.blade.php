@extends('app')

@section('content')
@php
    $vehicleName = trim(($vehicle->make ?? '') . ' ' . ($vehicle->model ?? ''));
@endphp

<style>
    .info-cell { transition: background .15s; }
    .info-cell:hover { background: #f8faff; }
    .action-btn { transition: all .2s ease; }
    .action-btn:hover { transform: translateY(-1px); box-shadow: 0 4px 14px rgba(0,0,0,.12); }
    .side-card { transition: transform .2s ease, box-shadow .2s ease; }
    .side-card:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(0,0,0,.08) !important; }
    @keyframes pulse-dot { 0%,100%{opacity:1;} 50%{opacity:.4;} }
    .pulse { animation: pulse-dot 2s ease-in-out infinite; }
    #del-modal { transition: opacity .2s ease; }
    #del-modal-box { transition: transform .2s ease, opacity .2s ease; }
</style>

<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-slate-100 px-4 py-8 md:px-8">
    <div class="max-w-7xl mx-auto">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-600 to-blue-700 flex items-center justify-center shadow-lg shadow-blue-200 flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">//www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">//www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to fleet
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

            <div class="lg:col-span-2 space-y-5">

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                    <div class="relative bg-gradient-to-r from-blue-600 via-blue-700 to-blue-800 px-6 pt-6 pb-16">
                        
                        <div class="absolute top-0 right-0 w-48 h-48 bg-white opacity-5 rounded-full -translate-y-1/2 translate-x-1/4"></div>
                        <div class="absolute bottom-0 right-24 w-24 h-24 bg-white opacity-5 rounded-full translate-y-1/2"></div>

                        <div class="relative flex items-start justify-between gap-4">
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-16 rounded-2xl bg-white/20 backdrop-blur flex items-center justify-center flex-shrink-0 border border-white/30">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path d="M3 7a2 2 0 012-2h10a2 2 0 012 2v3H3V7zm-1 5h16v2a2 2 0 01-2 2H4a2 2 0 01-2-2v-2zM6 15a1 1 0 100 2 1 1 0 000-2zm8 0a1 1 0 100 2 1 1 0 000-2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-xl font-bold text-white">{{ $vehicleName !== '' ? $vehicleName : 'Vehicle' }}</h2>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-blue-200 text-sm">{{ $vehicle->type ?? 'Unknown type' }}</span>
                                        <span class="text-blue-400">·</span>
                                        <span class="font-mono text-xs bg-white/20 text-white px-2 py-0.5 rounded-md border border-white/20">
                                            #{{ str_pad($vehicle->id, 3, '0', STR_PAD_LEFT) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            @if($vehicle->status === 'active')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-400/20 text-emerald-100 text-xs font-semibold rounded-full border border-emerald-300/30 flex-shrink-0">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 pulse"></span>
                                    Active
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-400/20 text-red-100 text-xs font-semibold rounded-full border border-red-300/30 flex-shrink-0">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                                    Inactive
                                </span>
                            @endif
                        </div>
                    </div>

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
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 pulse"></span>
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-red-50 text-red-600 text-sm font-semibold rounded-full border border-red-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                                        Inactive
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
                                    $nextDate  = $vehicle->next_maintenance_date;
                                    $overdue   = $nextDate && $nextDate->isPast();
                                    $dueSoon   = $nextDate && !$overdue && $nextDate->diffInDays(now()) <= 30;
                                @endphp
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1.5">Next Maintenance</p>
                                <p class="text-base font-semibold {{ $overdue ? 'text-red-600' : ($dueSoon ? 'text-amber-600' : 'text-gray-900') }}">
                                    {{ $nextDate ? $nextDate->format('M d, Y') : 'Not scheduled' }}
                                </p>
                                @if($nextDate)
                                    <p class="text-xs mt-0.5 {{ $overdue ? 'text-red-400' : ($dueSoon ? 'text-amber-400' : 'text-gray-400') }}">
                                        {{ $overdue ? (int) now()->diffInDays($nextDate) . ' days overdue' : (int) now()->diffInDays($nextDate) . ' days remaining' }}
                                    </p>
                                @endif
                            </div>

                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-2 px-6 py-4 bg-gray-50 border-t border-gray-100 mt-4">
                        <a href="{{ route('vehicles.edit', $vehicle->id) }}"
                           class="action-btn inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-amber-700 bg-amber-50 hover:bg-amber-100 border border-amber-200 rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 11l6.536-6.536a2 2 0 112.828 2.828L11 14H8v-3z"/>
                            </svg>
                            Edit Vehicle
                        </a>
                        <button type="button" onclick="openDelModal()"
                                class="action-btn inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-red-600 bg-red-50 hover:bg-red-100 border border-red-200 rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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

            <div class="space-y-4">

                <div class="side-card bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-5 py-3.5 border-b border-gray-100 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-sm font-semibold text-gray-700">Record Info</span>
                    </div>
                    <div class="divide-y divide-gray-50 px-5">

                        <div class="flex items-start gap-3 py-3.5">
                            <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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
                            <div class="w-8 h-8 rounded-lg bg-violet-50 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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

                <div class="side-card bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-5 py-3.5 border-b border-gray-100 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span class="text-sm font-semibold text-gray-700">Maintenance</span>
                    </div>
                    <div class="divide-y divide-gray-50 px-5">

                        <div class="flex items-start gap-3 py-3.5">
                            <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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
                                $nextDate = $vehicle->next_maintenance_date;
                                $overdue  = $nextDate && $nextDate->isPast();
                                $dueSoon  = $nextDate && !$overdue && (int) now()->diffInDays($nextDate) <= 30;
                                $iconColor   = $overdue ? 'text-red-500' : ($dueSoon ? 'text-amber-500' : 'text-gray-400');
                                $bgColor     = $overdue ? 'bg-red-50' : ($dueSoon ? 'bg-amber-50' : 'bg-gray-100');
                                $textColor   = $overdue ? 'text-red-600' : ($dueSoon ? 'text-amber-600' : 'text-gray-900');
                                $subColor    = $overdue ? 'text-red-400' : ($dueSoon ? 'text-amber-400' : 'text-gray-400');
                            @endphp
                            <div class="w-8 h-8 rounded-lg {{ $bgColor }} flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-medium">Next Service Due</p>
                                <p class="text-sm font-semibold {{ $textColor }} mt-0.5">
                                    {{ $nextDate ? $nextDate->format('M d, Y') : 'Not scheduled' }}
                                </p>
                                @if($nextDate)
                                    <p class="text-xs {{ $subColor }} mt-0.5">
                                        {{ $overdue
                                            ? (int) now()->diffInDays($nextDate) . ' days overdue'
                                            : (int) now()->diffInDays($nextDate) . ' days remaining' }}
                                    </p>
                                @endif
                            </div>
                        </div>

                    </div>

                    @if($nextDate)
                    @php
                        $lastDate    = $vehicle->last_maintenance_date;
                        $totalSpan   = $lastDate ? max(1, $lastDate->diffInDays($nextDate)) : 365;
                        $elapsed     = $lastDate ? min($totalSpan, $lastDate->diffInDays(now())) : $totalSpan;
                        $pct         = min(100, round($elapsed / $totalSpan * 100));
                        $barColor    = $overdue ? 'bg-red-500' : ($dueSoon ? 'bg-amber-500' : 'bg-emerald-500');
                    @endphp
                    <div class="px-5 pb-4">
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-xs text-gray-400">Service cycle progress</span>
                            <span class="text-xs font-semibold {{ $textColor }}">{{ $pct }}%</span>
                        </div>
                        <div class="h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                            <div class="{{ $barColor }} h-full rounded-full transition-all duration-700" data-width="{{ $pct }}"></div>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="side-card bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Quick Actions</p>
                    <div class="space-y-2">
                        <a href="{{ route('vehicles.edit', $vehicle->id) }}"
                           class="action-btn flex items-center gap-3 px-3 py-2.5 rounded-xl bg-amber-50 hover:bg-amber-100 border border-amber-100 text-amber-700 text-sm font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 11l6.536-6.536a2 2 0 112.828 2.828L11 14H8v-3z"/>
                            </svg>
                            Edit vehicle info
                        </a>
                        <a href="{{ route('vehicles.index') }}"
                           class="action-btn flex items-center gap-3 px-3 py-2.5 rounded-xl bg-blue-50 hover:bg-blue-100 border border-blue-100 text-blue-700 text-sm font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                            View all vehicles
                        </a>
                        <button type="button" onclick="openDelModal()"
                                class="action-btn w-full flex items-center gap-3 px-3 py-2.5 rounded-xl bg-red-50 hover:bg-red-100 border border-red-100 text-red-600 text-sm font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Delete this vehicle
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div id="del-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4"
     style="background: rgba(0,0,0,0.45); backdrop-filter: blur(4px);">
    <div id="del-modal-box" class="bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6 scale-95 opacity-0">
        <div class="w-14 h-14 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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

    document.querySelectorAll('[data-width]').forEach(el => {
        el.style.width = el.dataset.width + '%';
    });
</script>

@endsection