@extends('app')

@section('content')

<style>
    .action-btn { transition: all .2s ease; }
    .action-btn:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,0,0,.12); }
    .info-cell { transition: background .15s; }
    .info-cell:hover { background: #f8faff; }
    .side-card { transition: transform .2s ease, box-shadow .2s ease; }
    .side-card:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(0,0,0,.08) !important; }
    @keyframes pulse-dot { 0%,100%{opacity:1;} 50%{opacity:.4;} }
    .pulse { animation: pulse-dot 2s ease-in-out infinite; }
</style>

<div class="min-h-screen bg-gradient-to-br from-slate-50 via-indigo-50 to-slate-100 px-4 py-8 md:px-8">
    <div class="max-w-7xl mx-auto">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
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
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to roster
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

            <div class="lg:col-span-2 space-y-5">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                    <div class="relative bg-gradient-to-r from-indigo-600 via-indigo-700 to-indigo-800 px-6 pt-6 pb-16">
                        <div class="absolute top-0 right-0 w-48 h-48 bg-white opacity-5 rounded-full -translate-y-1/2 translate-x-1/4"></div>
                        <div class="absolute bottom-0 right-24 w-24 h-24 bg-white opacity-5 rounded-full translate-y-1/2"></div>

                        @php
                            $initials = collect(explode(' ', $driver->name))->map(fn($w) => strtoupper($w[0] ?? ''))->take(2)->implode('');
                            $licenseExpiry = $driver->license_expiry_date;
                            $licenseExpired = $licenseExpiry && $licenseExpiry->isPast();
                            $licenseExpiringSoon = $licenseExpiry && !$licenseExpired && $licenseExpiry->diffInDays(now()) <= 30;
                        @endphp

                        <div class="relative flex items-start justify-between gap-4">
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-16 rounded-2xl bg-white/20 backdrop-blur flex items-center justify-center flex-shrink-0 border border-white/30 text-white text-2xl font-bold">
                                    {{ $initials }}
                                </div>
                                <div>
                                    <h2 class="text-xl font-bold text-white">{{ $driver->name }}</h2>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-indigo-200 text-sm">Driver</span>
                                        <span class="text-indigo-400">·</span>
                                        <span class="font-mono text-xs bg-white/20 text-white px-2 py-0.5 rounded-md border border-white/20">
                                            #{{ str_pad($driver->id, 3, '0', STR_PAD_LEFT) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            @if($driver->status === 'active')
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
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1.5">License Expiry</p>
                                @if(!$licenseExpiry)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-gray-50 text-gray-600 text-sm font-semibold rounded-full border border-gray-200">
                                        Not set
                                    </span>
                                @elseif($licenseExpired)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-red-50 text-red-700 text-sm font-semibold rounded-full border border-red-200">
                                        Expired
                                    </span>
                                    <p class="text-xs text-red-500 mt-1">{{ $licenseExpiry->format('M d, Y') }}</p>
                                @elseif($licenseExpiringSoon)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-amber-50 text-amber-700 text-sm font-semibold rounded-full border border-amber-200">
                                        Expires soon
                                    </span>
                                    <p class="text-xs text-amber-500 mt-1">{{ $licenseExpiry->format('M d, Y') }}</p>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-50 text-emerald-700 text-sm font-semibold rounded-full border border-emerald-200">
                                        Valid
                                    </span>
                                    <p class="text-xs text-emerald-500 mt-1">Until {{ $licenseExpiry->format('M d, Y') }}</p>
                                @endif
                            </div>

                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-2 px-6 py-4 bg-gray-50 border-t border-gray-100 mt-4">
                        <a href="{{ route('drivers.edit', $driver->id) }}"
                           class="action-btn inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-amber-700 bg-amber-50 hover:bg-amber-100 border border-amber-200 rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 11l6.536-6.536a2 2 0 112.828 2.828L11 14H8v-3z"/>
                            </svg>
                            Edit Driver
                        </a>
                        <button type="button" onclick="openDelModal()"
                                class="action-btn inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-red-600 bg-red-50 hover:bg-red-100 border border-red-200 rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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
                                <p class="text-sm font-semibold text-gray-900 mt-0.5">{{ $driver->created_at->format('M d, Y') }}</p>
                                <p class="text-xs text-gray-400">{{ $driver->created_at->format('h:i A') }}</p>
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
                                <p class="text-sm font-semibold text-gray-900 mt-0.5">{{ $driver->updated_at->format('M d, Y') }}</p>
                                <p class="text-xs text-gray-400">{{ $driver->updated_at->format('h:i A') }}</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 py-3.5">
                            <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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

                <div class="side-card bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Quick Actions</p>
                    <div class="space-y-2">
                        <a href="{{ route('drivers.edit', $driver->id) }}"
                           class="action-btn flex items-center gap-3 px-3 py-2.5 rounded-xl bg-amber-50 hover:bg-amber-100 border border-amber-100 text-amber-700 text-sm font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 11l6.536-6.536a2 2 0 112.828 2.828L11 14H8v-3z"/>
                            </svg>
                            Edit driver info
                        </a>
                        <a href="{{ route('drivers.index') }}"
                           class="action-btn flex items-center gap-3 px-3 py-2.5 rounded-xl bg-indigo-50 hover:bg-indigo-100 border border-indigo-100 text-indigo-700 text-sm font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                            View all drivers
                        </a>
                        <button type="button" onclick="openDelModal()"
                                class="action-btn w-full flex items-center gap-3 px-3 py-2.5 rounded-xl bg-red-50 hover:bg-red-100 border border-red-100 text-red-600 text-sm font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Delete this driver
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div id="del-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4"
     style="background:rgba(0,0,0,.45);backdrop-filter:blur(4px)">
    <div id="del-box" class="bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6 scale-95 opacity-0 transition-all duration-200">
        <div class="w-14 h-14 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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
