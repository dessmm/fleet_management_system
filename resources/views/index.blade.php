    @extends('app')

    @section('content')

    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap');

        .vh-page * { font-family: 'DM Sans', sans-serif; box-sizing: border-box; }
        .vh-mono { font-family: 'DM Mono', monospace; }

        .vh-page {
            min-height: 100vh;
            background: #f7f6f3;
            background-image:
                radial-gradient(circle at 15% 0%, rgba(59,130,246,.06) 0%, transparent 55%),
                radial-gradient(circle at 90% 85%, rgba(59,130,246,.04) 0%, transparent 50%);
            padding: 2.5rem 2rem;
        }

        .vh-wrap { max-width: 1400px; margin: 0 auto; }

        .vh-breadcrumb {
            display: flex; align-items: center; gap: .5rem;
            margin-bottom: 2rem; color: #9e9b95; font-size: .8125rem;
        }
        .vh-breadcrumb a { color: #9e9b95; text-decoration: none; transition: color .15s; }
        .vh-breadcrumb a:hover { color: #111; }
        .vh-breadcrumb svg { width: 14px; height: 14px; }

        .vh-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 1.75rem; gap: 1rem; flex-wrap: wrap;
        }
        .vh-header-left { display: flex; align-items: center; gap: 1rem; }
        .vh-icon {
            width: 52px; height: 52px; border-radius: 14px;
            background: #2563eb;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; box-shadow: 0 4px 14px rgba(37,99,235,.3);
            font-size: 1.35rem; color: #fff;
        }
        .vh-title { font-size: 1.5rem; font-weight: 600; color: #111; letter-spacing: -.02em; line-height: 1.2; }
        .vh-subtitle { font-size: .8125rem; color: #9e9b95; margin-top: .2rem; }

        .vh-add-btn {
            display: inline-flex; align-items: center; gap: .5rem;
            padding: .6rem 1.25rem; border-radius: 11px;
            font-size: .8125rem; font-weight: 600; text-decoration: none;
            background: #2563eb; color: #fff;
            box-shadow: 0 4px 14px rgba(37,99,235,.3);
            transition: all .15s; white-space: nowrap;
        }
        .vh-add-btn:hover { background: #1d4ed8; box-shadow: 0 6px 18px rgba(37,99,235,.35); transform: translateY(-1px); }
        .vh-add-btn svg { width: 15px; height: 15px; }

        .vh-stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 1.5rem; }
        @media (max-width: 640px) { .vh-stats { grid-template-columns: repeat(2, 1fr); } }

        .vh-stat {
            background: #fff; border: 1px solid #e8e6e1;
            border-radius: 16px; padding: 1.1rem 1.25rem;
            display: flex; align-items: center; gap: .875rem;
            box-shadow: 0 1px 3px rgba(0,0,0,.04);
            transition: box-shadow .2s, transform .2s;
        }
        .vh-stat:hover { box-shadow: 0 6px 20px rgba(0,0,0,.08); transform: translateY(-2px); }
        .vh-stat-icon {
            width: 40px; height: 40px; border-radius: 11px;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .vh-stat-icon svg { width: 18px; height: 18px; }
        .vh-stat-num { font-size: 1.4rem; font-weight: 700; color: #111; letter-spacing: -.03em; line-height: 1; }
        .vh-stat-lbl { font-size: .75rem; color: #9e9b95; font-weight: 500; margin-top: .2rem; }

        .vh-card {
            background: #fff; border: 1px solid #e8e6e1; border-radius: 18px;
            overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,.04), 0 4px 16px rgba(0,0,0,.04);
        }
        .vh-card-header {
            padding: .875rem 1.5rem; border-bottom: 1px solid #f0ede8;
            display: flex; align-items: center; gap: .75rem; flex-wrap: wrap;
        }
        .vh-card-title { font-size: .8125rem; font-weight: 600; color: #333; }
        .vh-count {
            display: inline-flex; align-items: center;
            background: #eff6ff; border: 1px solid #bfdbfe;
            color: #1d4ed8; font-size: .7rem; font-weight: 700;
            padding: .15rem .55rem; border-radius: 99px;
            font-family: 'DM Mono', monospace;
        }

        .vh-search-wrap { margin-left: auto; position: relative; }
        .vh-search-wrap svg { position: absolute; left: .75rem; top: 50%; transform: translateY(-50%); width: 14px; height: 14px; color: #b0ada7; pointer-events: none; }
        .vh-search {
            padding: .5rem .875rem .5rem 2.25rem; font-size: .8125rem; background: #fafaf8;
            border: 1px solid #e8e6e1; border-radius: 9px; color: #333; width: 220px;
            font-family: 'DM Sans', sans-serif; transition: all .15s;
        }
        .vh-search::placeholder { color: #c0bdb8; }
        .vh-search:focus { outline: none; background: #fff; border-color: #60a5fa; box-shadow: 0 0 0 3px rgba(96,165,250,.2); width: 260px; }

        .vh-table { width: 100%; border-collapse: collapse; }
        .vh-table thead tr { background: #fafaf8; border-bottom: 1px solid #f0ede8; }
        .vh-table th {
            padding: .75rem 1.25rem; text-align: left;
            font-size: .7rem; font-weight: 600; letter-spacing: .07em;
            text-transform: uppercase; color: #b0ada7; white-space: nowrap;
        }
        .vh-table th:last-child { text-align: right; }
        .vh-table tbody tr { border-bottom: 1px solid #f7f6f3; transition: background .12s; }
        .vh-table tbody tr:last-child { border-bottom: none; }
        .vh-table tbody tr:hover { background: #f3f7ff; }
        .vh-table td { padding: .875rem 1.25rem; vertical-align: middle; }

        .vh-actions { display: flex; align-items: center; justify-content: flex-end; gap: .4rem; }
        .vh-btn { display: inline-flex; align-items: center; gap: .3rem; padding: .4rem .8rem; border-radius: 8px; font-size: .75rem; font-weight: 600; text-decoration: none; cursor: pointer; border: 1px solid transparent; transition: all .15s; font-family: 'DM Sans', sans-serif; white-space: nowrap; }
        .vh-btn svg { width: 12px; height: 12px; flex-shrink: 0; }
        .vh-btn-view { background: #eff6ff; border-color: #bfdbfe; color: #1d4ed8; }
        .vh-btn-view:hover { background: #dbeafe; }
        .vh-btn-edit { background: #fffbeb; border-color: #fde68a; color: #92400e; }
        .vh-btn-edit:hover { background: #fef3c7; }
        .vh-btn-del  { background: #fff5f5; border-color: #fecaca; color: #dc2626; }
        .vh-btn-del:hover { background: #fee2e2; }

        .vh-footer { padding: .75rem 1.5rem; border-top: 1px solid #f0ede8; background: #fafaf8; display: flex; align-items: center; justify-content: space-between; }
        .vh-footer-text { font-size: .72rem; color: #b0ada7; }

        .vh-empty { display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 5rem 2rem; text-align: center; }
        .vh-empty-icon { width: 72px; height: 72px; border-radius: 20px; background: #eff6ff; border: 1px solid #bfdbfe; display: flex; align-items: center; justify-content: center; font-size: 1.75rem; margin-bottom: 1.25rem; }
        .vh-empty-title { font-size: 1rem; font-weight: 600; color: #333; margin-bottom: .4rem; }
        .vh-empty-sub { font-size: .8375rem; color: #9e9b95; max-width: 280px; line-height: 1.5; margin-bottom: 1.5rem; }

        .delete-modal-overlay { backdrop-filter: blur(4px); }
    </style>

    <div class="vh-page">
    <div class="vh-wrap">

        <nav class="vh-breadcrumb">
            <a href="/">Home</a>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            <span>Vehicles</span>
        </nav>

        {{-- ── PAGE HEADER ─────────────────────────────────────────────────────── --}}
        <div class="max-w-7xl mx-auto mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-600 to-blue-700 flex items-center justify-center shadow-lg shadow-blue-200 flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="M8 17a2 2 0 1 0 4 0 2 2 0 0 0-4 0m8 0a2 2 0 1 0 4 0 2 2 0 0 0-4 0M3 7h2l2-4h10l2 4h2a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V8a1 1 0 0 1 1-1z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 leading-tight">Vehicle Fleet</h1>
                        <p class="text-gray-500 text-sm mt-0.5">Manage and monitor all registered vehicles</p>
                    </div>
                </div>
                <a href="{{ route('vehicles.create') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white text-sm font-semibold rounded-xl shadow-md shadow-blue-200 hover:shadow-lg hover:shadow-blue-300 hover:-translate-y-0.5 transition-all duration-200 self-start sm:self-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add New Vehicle
                </a>
            </div>
        </div>

        {{-- ── STATS ROW ────────────────────────────────────────────────────────── --}}
        <div class="max-w-7xl mx-auto mb-6 grid grid-cols-2 md:grid-cols-4 gap-4">
            @php
        $total        = count($vehicles);
        $active       = $vehicles->where('status', 'active')->count();
        $inactive     = $vehicles->where('status', 'inactive')->count();
        $maintenance  = $vehicles->where('status', 'in_maintenance')->count();
        $types        = $vehicles->unique('type')->count();
    @endphp

    {{-- Add a new stat card for In Maintenance --}}
    <div class="stat-card bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center flex-shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
        </div>
        <div>
            <p class="text-2xl font-bold text-gray-900">{{ $maintenance }}</p>
            <p class="text-xs text-gray-500 font-medium">In Maintenance</p>
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
                <div class="w-10 h-10 rounded-xl bg-violet-100 flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-violet-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h8m-8 6h16"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ $types }}</p>
                    <p class="text-xs text-gray-500 font-medium">Vehicle Types</p>
                </div>
            </div>
        </div>

        {{-- ── MAIN TABLE CARD ──────────────────────────────────────────────────── --}}
        <div class="max-w-7xl mx-auto">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                {{-- Card header with search --}}
                <div class="px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center gap-3">
                    <div class="flex items-center gap-2 flex-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <span class="text-sm font-semibold text-gray-700">All Vehicles</span>
                        <span class="ml-1 px-2 py-0.5 text-xs font-semibold bg-blue-100 text-blue-700 rounded-full">{{ count($vehicles) }}</span>
                    </div>
                    {{-- Search --}}
                    <div class="relative sm:w-64">
                        <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/>
                        </svg>
                        <input id="search-input" type="text" placeholder="Search vehicles…"
                            class="vh-search w-full pl-9 pr-3 py-2 text-sm bg-gray-50 border border-gray-200 rounded-lg text-gray-700 placeholder-gray-400 focus:bg-white transition-all duration-200">
                    </div>
                </div>

                @if(count($vehicles) > 0)
                    <div class="overflow-x-auto">
                        <table class="vh-table" id="vehicles-table">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-100">
                                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Vehicle</th>
                                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">License Plate</th>
                                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Type</th>
                                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Capacity</th>
                                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="text-right px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach($vehicles as $vehicle)
                                    @php
                                        $vehicleName = trim(($vehicle->make ?? '') . ' ' . ($vehicle->model ?? ''));
                                    @endphp
                                    <tr class="vehicle-row group" data-name="{{ strtolower($vehicleName) }}" data-plate="{{ strtolower($vehicle->plate_number ?? '') }}">

                                        {{-- Vehicle Name --}}
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center shadow-sm flex-shrink-0">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M3 7a2 2 0 012-2h10a2 2 0 012 2v3H3V7zm-1 5h16v2a2 2 0 01-2 2H4a2 2 0 01-2-2v-2zM6 15a1 1 0 100 2 1 1 0 000-2zm8 0a1 1 0 100 2 1 1 0 000-2z"/>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-semibold text-gray-900">{{ $vehicleName !== '' ? $vehicleName : 'Vehicle' }}</p>
                                                    <p class="text-xs text-gray-400">ID #{{ str_pad($vehicle->id, 3, '0', STR_PAD_LEFT) }}</p>
                                                </div>
                                            </div>
                                        </td>

                                        {{-- License Plate --}}
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-gray-900 text-white text-xs font-mono font-bold rounded-lg tracking-widest shadow-sm">
                                                {{ $vehicle->plate_number }}
                                            </span>
                                        </td>

                                        {{-- Type --}}
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center px-2.5 py-1 bg-violet-50 text-violet-700 text-xs font-semibold rounded-lg border border-violet-100">
                                                {{ $vehicle->type ?? 'N/A' }}
                                            </span>
                                        </td>

                                        {{-- Capacity --}}
                                        <td class="px-6 py-4">
                                            <span class="text-sm text-gray-700 font-medium">
                                                @if($vehicle->capacity)
                                                    {{ number_format($vehicle->capacity) }} <span class="text-gray-400 font-normal text-xs">kg</span>
                                                @else
                                                    <span class="text-gray-400">—</span>
                                                @endif
                                            </span>
                                        </td>

                                        {{-- Status --}}
                                        <td class="px-6 py-4">
        @if($vehicle->status === 'active')
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-50 text-emerald-700 text-xs font-semibold rounded-full border border-emerald-200">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                Active
            </span>
        @elseif($vehicle->status === 'in_maintenance')
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-amber-50 text-amber-700 text-xs font-semibold rounded-full border border-amber-200">
                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                In Maintenance
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
                                                <a href="{{ route('vehicles.show', $vehicle->id) }}"
                                                class="action-btn inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-blue-700 bg-blue-50 hover:bg-blue-100 border border-blue-200 rounded-lg"
                                                title="View vehicle">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                    </svg>
                                                    View
                                                </a>
                                                <a href="{{ route('vehicles.edit', $vehicle->id) }}"
                                                class="action-btn inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-amber-700 bg-amber-50 hover:bg-amber-100 border border-amber-200 rounded-lg"
                                                title="Edit vehicle">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                                    </svg>
                                                    Edit
                                                </a>
                                                <button type="button"
                                                        data-delete-id="{{ $vehicle->id }}"
                                                        data-delete-name="{{ $vehicleName !== '' ? $vehicleName : ('Vehicle #' . str_pad($vehicle->id, 3, '0', STR_PAD_LEFT)) }}"
                                                        class="delete-btn action-btn inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 border border-red-200 rounded-lg"
                                                        title="Delete vehicle">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                    Delete
                                                </button>
                                                {{-- Hidden delete form --}}
                                                <form id="delete-form-{{ $vehicle->id }}" action="{{ route('vehicles.destroy', $vehicle->id) }}" method="POST" class="hidden">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Table footer --}}
                    <div class="px-6 py-3 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
                        <p class="text-xs text-gray-400" id="row-count">Showing {{ count($vehicles) }} vehicle(s)</p>
                        <p class="text-xs text-gray-400">Fleet Management System</p>
                    </div>

                @else
                    {{-- Empty state --}}
                    <div class="flex flex-col items-center justify-center py-20 px-4 text-center">
                        <div class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center mb-5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 17a2 2 0 1 0 4 0 2 2 0 0 0-4 0m8 0a2 2 0 1 0 4 0 2 2 0 0 0-4 0M3 7h2l2-4h10l2 4h2a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V8a1 1 0 0 1 1-1z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">No vehicles found</h3>
                        <p class="text-gray-400 text-sm mb-6 max-w-xs">Your fleet is empty. Add your first vehicle to get started with fleet management.</p>
                        <a href="{{ route('vehicles.create') }}"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white text-sm font-semibold rounded-xl shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                            Add First Vehicle
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ── DELETE CONFIRMATION MODAL ────────────────────────────────────────── --}}
    <div id="delete-modal" class="delete-modal-overlay fixed inset-0 z-50 hidden flex items-center justify-center p-4"
        style="background: rgba(0,0,0,0.45);">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 transform transition-all duration-200 scale-95 opacity-0" id="modal-box">
            <div class="flex items-center justify-center w-14 h-14 bg-red-100 rounded-full mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M4 7h16"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 text-center mb-1">Delete Vehicle?</h3>
            <p class="text-sm text-gray-500 text-center mb-6">
                You are about to permanently delete <strong id="modal-vehicle-name" class="text-gray-800"></strong>. This action cannot be undone.
            </p>
            <div class="flex gap-3">
                <button onclick="closeDeleteModal()"
                        class="flex-1 px-4 py-2.5 text-sm font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors duration-200">
                    Cancel
                </button>
                <button id="confirm-delete-btn"
                        class="flex-1 px-4 py-2.5 text-sm font-semibold text-white bg-red-500 hover:bg-red-600 rounded-xl transition-colors duration-200 shadow-md shadow-red-200">
                    Yes, Delete
                </button>
            </div>
        </div>
    </div>

    <script>
        // ── Live search ───────────────────────────────────────────────────────
        const searchInput = document.getElementById('search-input');
        const tableRows   = document.querySelectorAll('#vehicles-table tbody tr');
        const rowCount    = document.getElementById('row-count');

        searchInput && searchInput.addEventListener('input', function () {
            const query = this.value.toLowerCase().trim();
            let visible = 0;
            tableRows.forEach(row => {
                const name  = row.dataset.name  || '';
                const plate = row.dataset.plate || '';
                const match = name.includes(query) || plate.includes(query);
                row.style.display = match ? '' : 'none';
                if (match) visible++;
            });
            if (rowCount) {
                rowCount.textContent = query
                    ? `Showing ${visible} of {{ count($vehicles) }} vehicle(s)`
                    : `Showing {{ count($vehicles) }} vehicle(s)`;
            }
        });

        // ── Delete modal ──────────────────────────────────────────────────────
        let pendingDeleteId = null;

        // Setup delete button event listeners
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.deleteId;
                const name = this.dataset.deleteName;
                openDeleteModal(id, name);
            });
        });

        function openDeleteModal(id, name) {
            pendingDeleteId = id;
            document.getElementById('modal-vehicle-name').textContent = name;
            const modal = document.getElementById('delete-modal');
            const box   = document.getElementById('modal-box');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                box.classList.remove('scale-95', 'opacity-0');
                box.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeDeleteModal() {
            const modal = document.getElementById('delete-modal');
            const box   = document.getElementById('modal-box');
            box.classList.remove('scale-100', 'opacity-100');
            box.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                pendingDeleteId = null;
            }, 200);
        }

        document.getElementById('confirm-delete-btn').addEventListener('click', function () {
            if (pendingDeleteId) {
                document.getElementById('delete-form-' + pendingDeleteId).submit();
            }
        });

        // Close modal on backdrop click
        document.getElementById('delete-modal').addEventListener('click', function (e) {
            if (e.target === this) closeDeleteModal();
        });
    </script>

    @endsection