@extends('app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap');

    .dr-page * { font-family: 'DM Sans', sans-serif; box-sizing: border-box; }
    .dr-mono { font-family: 'DM Mono', monospace; }

    .dr-page {
        min-height: 100vh;
        background: #f7f6f3;
        background-image:
            radial-gradient(circle at 15% 0%, rgba(99,102,241,.06) 0%, transparent 55%),
            radial-gradient(circle at 90% 85%, rgba(99,102,241,.04) 0%, transparent 50%);
        padding: 2.5rem 2rem;
    }

    .dr-wrap { max-width: 1400px; margin: 0 auto; }

    .dr-breadcrumb {
        display: flex; align-items: center; gap: .5rem;
        margin-bottom: 2rem; color: #9e9b95; font-size: .8125rem;
    }
    .dr-breadcrumb a { color: #9e9b95; text-decoration: none; transition: color .15s; }
    .dr-breadcrumb a:hover { color: #111; }
    .dr-breadcrumb svg { width: 14px; height: 14px; }

    .dr-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 1.75rem; gap: 1rem; flex-wrap: wrap;
    }
    .dr-header-left { display: flex; align-items: center; gap: 1rem; }
    .dr-icon {
        width: 52px; height: 52px; border-radius: 14px;
        background: #6366f1;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; box-shadow: 0 4px 14px rgba(99,102,241,.3);
        color: #fff; font-size: 1.35rem;
    }
    .dr-title { font-size: 1.5rem; font-weight: 600; color: #111; letter-spacing: -.02em; line-height: 1.2; }
    .dr-subtitle { font-size: .8125rem; color: #9e9b95; margin-top: .2rem; }

    .dr-add-btn {
        display: inline-flex; align-items: center; gap: .5rem;
        padding: .6rem 1.25rem; border-radius: 11px;
        font-size: .8125rem; font-weight: 600; text-decoration: none;
        background: #6366f1; color: #fff;
        box-shadow: 0 4px 14px rgba(99,102,241,.3);
        transition: all .15s; white-space: nowrap;
    }
    .dr-add-btn:hover { background: #4f46e5; box-shadow: 0 6px 18px rgba(99,102,241,.35); transform: translateY(-1px); }
    .dr-add-btn svg { width: 15px; height: 15px; }

    .dr-stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 1.5rem; }
    @media (max-width: 640px) { .dr-stats { grid-template-columns: repeat(2, 1fr); } }

    .dr-stat {
        background: #fff; border: 1px solid #e8e6e1;
        border-radius: 16px; padding: 1.1rem 1.25rem;
        display: flex; align-items: center; gap: .875rem;
        box-shadow: 0 1px 3px rgba(0,0,0,.04);
        transition: box-shadow .2s, transform .2s;
    }
    .dr-stat:hover { box-shadow: 0 6px 20px rgba(0,0,0,.08); transform: translateY(-2px); }
    .dr-stat-icon {
        width: 40px; height: 40px; border-radius: 11px;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .dr-stat-icon svg { width: 18px; height: 18px; }
    .dr-stat-num { font-size: 1.4rem; font-weight: 700; color: #111; letter-spacing: -.03em; line-height: 1; }
    .dr-stat-lbl { font-size: .75rem; color: #9e9b95; font-weight: 500; margin-top: .2rem; }

    .dr-card { background: #fff; border: 1px solid #e8e6e1; border-radius: 18px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,.04), 0 4px 16px rgba(0,0,0,.04); }
    .dr-card-header { padding: .875rem 1.5rem; border-bottom: 1px solid #f0ede8; display: flex; align-items: center; gap: .75rem; flex-wrap: wrap; }
    .dr-card-title { font-size: .8125rem; font-weight: 600; color: #333; }
    .dr-count { display: inline-flex; align-items: center; background: #eef2ff; border: 1px solid #c7d2fe; color: #4338ca; font-size: .7rem; font-weight: 700; padding: .15rem .55rem; border-radius: 99px; font-family: 'DM Mono', monospace; }

    .dr-search-wrap { margin-left: auto; position: relative; }
    .dr-search-wrap svg { position: absolute; left: .75rem; top: 50%; transform: translateY(-50%); width: 14px; height: 14px; color: #b0ada7; pointer-events: none; }
    .dr-search { padding: .5rem .875rem .5rem 2.25rem; font-size: .8125rem; background: #fafaf8; border: 1px solid #e8e6e1; border-radius: 9px; color: #333; width: 220px; font-family: 'DM Sans', sans-serif; transition: all .15s; }
    .dr-search::placeholder { color: #c0bdb8; }
    .dr-search:focus { outline: none; background: #fff; border-color: #c7d2fe; box-shadow: 0 0 0 3px rgba(199,210,254,.2); width: 260px; }

    .dr-table { width: 100%; border-collapse: collapse; }
    .dr-table thead tr { background: #fafaf8; border-bottom: 1px solid #f0ede8; }
    .dr-table th { padding: .75rem 1.25rem; text-align: left; font-size: .7rem; font-weight: 600; letter-spacing: .07em; text-transform: uppercase; color: #b0ada7; white-space: nowrap; }
    .dr-table th:last-child { text-align: right; }
    .dr-table tbody tr { border-bottom: 1px solid #f7f6f3; transition: background .12s; }
    .dr-table tbody tr:last-child { border-bottom: none; }
    .dr-table tbody tr:hover { background: #eff2ff; }
    .dr-table td { padding: .875rem 1.25rem; vertical-align: middle; }

    .dr-actions { display: flex; align-items: center; justify-content: flex-end; gap: .4rem; }
    .dr-btn { display: inline-flex; align-items: center; gap: .3rem; padding: .4rem .8rem; border-radius: 8px; font-size: .75rem; font-weight: 600; text-decoration: none; cursor: pointer; border: 1px solid transparent; transition: all .15s; font-family: 'DM Sans', sans-serif; white-space: nowrap; }
    .dr-btn svg { width: 12px; height: 12px; flex-shrink: 0; }
    .dr-btn-view { background: #eff6ff; border-color: #bfdbfe; color: #1d4ed8; }
    .dr-btn-view:hover { background: #dbeafe; }
    .dr-btn-edit { background: #fffbeb; border-color: #fde68a; color: #92400e; }
    .dr-btn-edit:hover { background: #fef3c7; }
    .dr-btn-del { background: #fff5f5; border-color: #fecaca; color: #dc2626; }
    .dr-btn-del:hover { background: #fee2e2; }

    .dr-footer { padding: .75rem 1.5rem; border-top: 1px solid #f0ede8; background: #fafaf8; display: flex; align-items: center; justify-content: space-between; }
    .dr-footer-text { font-size: .72rem; color: #b0ada7; }

    .dr-empty { display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 5rem 2rem; text-align: center; }
    .dr-empty-icon { width: 72px; height: 72px; border-radius: 20px; background: #eef2ff; border: 1px solid #c7d2fe; display: flex; align-items: center; justify-content: center; margin-bottom: 1.25rem; }
    .dr-empty-title { font-size: 1rem; font-weight: 600; color: #333; margin-bottom: .4rem; }
    .dr-empty-sub { font-size: .8375rem; color: #9e9b95; max-width: 280px; line-height: 1.5; margin-bottom: 1.5rem; }

    @keyframes pulse-dot { 0%,100%{opacity:1;} 50%{opacity:.4;} }
    .pulse { animation: pulse-dot 2s ease-in-out infinite; }
</style>

<div class="dr-page">
<div class="dr-wrap">

    {{-- ── PAGE HEADER ─────────────────────────────────────────── --}}
    <nav class="dr-breadcrumb">
        <a href="/">Home</a>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <span>Drivers</span>
    </nav>
    <div class="max-w-7xl mx-auto mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-600 to-indigo-700 flex items-center justify-center shadow-lg shadow-indigo-200 flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 leading-tight">Driver Roster</h1>
                    <p class="text-gray-500 text-sm mt-0.5">Manage and monitor all registered drivers</p>
                </div>
            </div>
            <a href="{{ route('drivers.create') }}"
               class="action-btn inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white text-sm font-semibold rounded-xl shadow-md shadow-indigo-200 hover:shadow-lg hover:shadow-indigo-300 hover:-translate-y-0.5 self-start sm:self-auto">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Add New Driver
            </a>
        </div>
    </div>

    {{-- ── STATS ROW ────────────────────────────────────────────── --}}
    <div class="max-w-7xl mx-auto mb-6 grid grid-cols-2 md:grid-cols-4 gap-4">
        @php
            $total    = count($drivers);
            $active   = $drivers->where('status','active')->count();
            $inactive = $drivers->where('status','inactive')->count();
        @endphp

        <div class="stat-card bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-indigo-100 flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ $total }}</p>
                <p class="text-xs text-gray-500 font-medium">Total Drivers</p>
            </div>
        </div>

        <div class="stat-card bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ $active }}</p>
                <p class="text-xs text-gray-500 font-medium">Active</p>
            </div>
        </div>

        <div class="stat-card bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-red-100 flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ $inactive }}</p>
                <p class="text-xs text-gray-500 font-medium">Inactive</p>
            </div>
        </div>

        <div class="stat-card bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ $total > 0 ? round($active / $total * 100) : 0 }}%</p>
                <p class="text-xs text-gray-500 font-medium">Active Rate</p>
            </div>
        </div>
    </div>

    {{-- ── MAIN TABLE CARD ──────────────────────────────────────── --}}
    <div class="max-w-7xl mx-auto">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            {{-- Card header + search --}}
            <div class="px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center gap-3">
                <div class="flex items-center gap-2 flex-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <span class="text-sm font-semibold text-gray-700">All Drivers</span>
                    <span class="ml-1 px-2 py-0.5 text-xs font-semibold bg-indigo-100 text-indigo-700 rounded-full">{{ $total }}</span>
                </div>
                <div class="relative sm:w-64">
                    <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/>
                    </svg>
                    <input id="search-input" type="text" placeholder="Search drivers…"
                           class="dr-search w-full pl-9 pr-3 py-2 text-sm bg-gray-50 border border-gray-200 rounded-lg text-gray-700 placeholder-gray-400 focus:bg-white transition-all duration-200">
                </div>
            </div>

            @if(count($drivers) > 0)
                <div class="overflow-x-auto">
                    <table class="dr-table" id="drivers-table">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Driver</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">License No.</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">License Status</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Contact</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="text-right px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($drivers as $driver)
                                @php
                                    $initials = collect(explode(' ', $driver->name))->map(fn($w) => strtoupper($w[0] ?? ''))->take(2)->implode('');
                                    $colors = ['from-indigo-500 to-indigo-700','from-blue-500 to-blue-700','from-violet-500 to-violet-700','from-teal-500 to-teal-700','from-cyan-500 to-cyan-700'];
                                    $color  = $colors[$driver->id % count($colors)];
                                    $expiry = $driver->license_expiry_date;
                                    $isExpired = $expiry && $expiry->isPast();
                                    $isExpiringSoon = $expiry && !$isExpired && $expiry->diffInDays(now()) <= 30;
                                @endphp
                                <tr class="driver-row group"
                                    data-name="{{ strtolower($driver->name) }}"
                                    data-license="{{ strtolower($driver->license_number) }}">

                                    {{-- Driver --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br {{ $color }} flex items-center justify-center text-white text-sm font-bold flex-shrink-0 shadow-sm">
                                                {{ $initials }}
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-gray-900">{{ $driver->name }}</p>
                                                <p class="text-xs text-gray-400">ID #{{ str_pad($driver->id, 3, '0', STR_PAD_LEFT) }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- License --}}
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-gray-900 text-white text-xs font-mono font-bold rounded-lg tracking-wider shadow-sm">
                                            {{ $driver->license_number }}
                                        </span>
                                    </td>

                                    {{-- License Status --}}
                                    <td class="px-6 py-4">
                                        @if(!$expiry)
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-gray-50 text-gray-600 text-xs font-semibold rounded-full border border-gray-200">
                                                Not set
                                            </span>
                                        @elseif($isExpired)
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-red-50 text-red-700 text-xs font-semibold rounded-full border border-red-200">
                                                Expired ({{ $expiry->format('M d, Y') }})
                                            </span>
                                        @elseif($isExpiringSoon)
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-amber-50 text-amber-700 text-xs font-semibold rounded-full border border-amber-200">
                                                Expires soon ({{ $expiry->format('M d, Y') }})
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-50 text-emerald-700 text-xs font-semibold rounded-full border border-emerald-200">
                                                Valid until {{ $expiry->format('M d, Y') }}
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Contact --}}
                                    <td class="px-6 py-4">
                                        <span class="text-sm text-gray-700">{{ $driver->contact }}</span>
                                    </td>

                                    {{-- Status --}}
                                    <td class="px-6 py-4">
                                        @if($driver->status === 'active')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-50 text-emerald-700 text-xs font-semibold rounded-full border border-emerald-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 pulse"></span>
                                                Active
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-red-50 text-red-600 text-xs font-semibold rounded-full border border-red-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                                                Inactive
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Actions --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <a href="{{ route('drivers.show', $driver->id) }}"
                                               class="action-btn inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-blue-700 bg-blue-50 hover:bg-blue-100 border border-blue-200 rounded-lg">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                                View
                                            </a>
                                            <a href="{{ route('drivers.edit', $driver->id) }}"
                                               class="action-btn inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-amber-700 bg-amber-50 hover:bg-amber-100 border border-amber-200 rounded-lg">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                                </svg>
                                                Edit
                                            </a>
                                            <button type="button"
                                                    data-delete-id="{{ $driver->id }}"
                                                    data-delete-name="{{ addslashes($driver->name) }}"
                                                    class="action-btn delete-btn inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 border border-red-200 rounded-lg">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                                Delete
                                            </button>
                                            <form id="delete-form-{{ $driver->id }}" action="{{ route('drivers.destroy', $driver->id) }}" method="POST" class="hidden">
                                                @csrf @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-3 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
                    <p class="text-xs text-gray-400" id="row-count">Showing {{ $total }} driver(s)</p>
                    <p class="text-xs text-gray-400">Fleet Management System</p>
                </div>

            @else
                <div class="flex flex-col items-center justify-center py-20 px-4 text-center">
                    <div class="w-20 h-20 bg-indigo-50 rounded-full flex items-center justify-center mb-5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">No drivers found</h3>
                    <p class="text-gray-400 text-sm mb-6 max-w-xs">Your driver roster is empty. Add your first driver to get started.</p>
                    <a href="{{ route('drivers.create') }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white text-sm font-semibold rounded-xl shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                        Add First Driver
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Delete Modal --}}
<div id="delete-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4"
     style="background:rgba(0,0,0,.45);backdrop-filter:blur(4px)">
    <div id="modal-box" class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 scale-95 opacity-0 transition-all duration-200">
        <div class="w-14 h-14 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
        </div>
        <h3 class="text-lg font-bold text-gray-900 text-center mb-1">Delete Driver?</h3>
        <p class="text-sm text-gray-500 text-center mb-6">
            Permanently remove <strong id="modal-driver-name" class="text-gray-800"></strong> from the roster? This cannot be undone.
        </p>
        <div class="flex gap-3">
            <button onclick="closeDeleteModal()" class="flex-1 px-4 py-2.5 text-sm font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">Cancel</button>
            <button id="confirm-delete-btn" class="flex-1 px-4 py-2.5 text-sm font-semibold text-white bg-red-500 hover:bg-red-600 rounded-xl transition-colors shadow-md shadow-red-200">Yes, Delete</button>
        </div>
    </div>
</div>

<script>
    const searchInput = document.getElementById('search-input');
    const tableRows   = document.querySelectorAll('#drivers-table tbody tr');
    const rowCount    = document.getElementById('row-count');
    searchInput && searchInput.addEventListener('input', function() {
        const q = this.value.toLowerCase().trim();
        let visible = 0;
        tableRows.forEach(r => {
            const match = (r.dataset.name||'').includes(q) || (r.dataset.license||'').includes(q);
            r.style.display = match ? '' : 'none';
            if (match) visible++;
        });
        if (rowCount) rowCount.textContent = q ? `Showing ${visible} of {{ $total }} driver(s)` : `Showing {{ $total }} driver(s)`;
    });

    let pendingId = null;
    function openDeleteModal(id, name) {
        pendingId = id;
        document.getElementById('modal-driver-name').textContent = name;
        const m = document.getElementById('delete-modal'), b = document.getElementById('modal-box');
        m.classList.remove('hidden'); m.classList.add('flex');
        setTimeout(() => { b.classList.remove('scale-95','opacity-0'); b.classList.add('scale-100','opacity-100'); }, 10);
    }
    function closeDeleteModal() {
        const m = document.getElementById('delete-modal'), b = document.getElementById('modal-box');
        b.classList.remove('scale-100','opacity-100'); b.classList.add('scale-95','opacity-0');
        setTimeout(() => { m.classList.add('hidden'); m.classList.remove('flex'); pendingId = null; }, 200);
    }
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            openDeleteModal(this.dataset.deleteId, this.dataset.deleteName);
        });
    });
    document.getElementById('confirm-delete-btn').addEventListener('click', () => { if (pendingId) document.getElementById('delete-form-'+pendingId).submit(); });
    document.getElementById('delete-modal').addEventListener('click', function(e) { if (e.target === this) closeDeleteModal(); });
</script>

@endsection