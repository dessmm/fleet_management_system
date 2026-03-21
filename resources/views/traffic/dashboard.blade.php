@extends('app')

@section('content')
<style>
    .traffic-row { transition: background-color .15s ease, transform .15s ease; }
    .traffic-row:hover { background-color: #fffbeb !important; transform: translateX(2px); }
    .action-btn { transition: all .2s ease; }
    .action-btn:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,0,0,.14); }
    .stat-card { transition: transform .2s ease, box-shadow .2s ease; }
    .stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(0,0,0,.1) !important; }
    #search-input:focus { outline: none; box-shadow: 0 0 0 3px rgba(217,119,6,.2); }
    @keyframes pulse-dot { 0%,100%{opacity:1;} 50%{opacity:.4;} }
    .pulse { animation: pulse-dot 2s ease-in-out infinite; }
    @keyframes spin { to { transform: rotate(360deg); } }
    .spin { animation: spin 1s linear infinite; }
    @keyframes fadeInRow { from { opacity:0; transform:translateX(-6px); } to { opacity:1; transform:translateX(0); } }
    .row-fade { animation: fadeInRow .3s ease; }
    .stat-updated { animation: statPop .4s ease; }
    @keyframes statPop { 0%{transform:scale(1);} 50%{transform:scale(1.08);} 100%{transform:scale(1);} }
</style>

<div class="min-h-screen bg-gradient-to-br from-slate-50 via-amber-50 to-slate-100 px-4 py-8 md:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-500 to-amber-600 flex items-center justify-center shadow-lg shadow-amber-200 flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 01.553-.894L9 2m0 18l6-3m-6 3V2m6 15l6-3m-6 3V5m6 9V3m0 0l-6 3m6-3l-6 3"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 leading-tight">Traffic Intelligence</h1>
                    <p class="text-gray-500 text-sm mt-0.5">Real-time vehicle tracking, congestion analysis & route optimization</p>
                </div>
            </div>
            <div class="flex items-center gap-2 self-start sm:self-auto">
                <button onclick="refreshData()" id="refresh-btn"
                        class="action-btn inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-600 text-sm font-medium rounded-xl shadow-sm hover:bg-gray-50">
                    <svg id="refresh-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Refresh
                </button>
                <a href="{{ route('traffic.analytics') }}"
                   class="action-btn inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-600 text-sm font-medium rounded-xl shadow-sm hover:bg-gray-50">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    Analytics
                </a>
                <a href="{{ route('traffic.hotspots-view') }}"
                   class="action-btn inline-flex items-center gap-2 px-5 py-2 bg-gradient-to-r from-amber-500 to-amber-600 text-white text-sm font-semibold rounded-xl shadow-md shadow-amber-200 hover:shadow-lg hover:shadow-amber-300 hover:-translate-y-0.5">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"/>
                    </svg>
                    View Hotspots
                </a>
            </div>
        </div>

        {{-- Stat Cards --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div class="stat-card bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-amber-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 17a2 2 0 104 0 2 2 0 00-4 0m8 0a2 2 0 104 0 2 2 0 00-4 0M3 7h2l2-4h10l2 4h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1V8a1 1 0 011-1z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900" id="stat-active">{{ count($activeTraffic) }}</p>
                    <p class="text-xs text-gray-500 font-medium">Active Vehicles</p>
                </div>
            </div>

            <div class="stat-card bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-red-100 flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-red-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900" id="stat-congestion">{{ $congestionCount }}</p>
                    <p class="text-xs text-gray-500 font-medium">Congestion Alerts</p>
                </div>
            </div>

            <div class="stat-card bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-violet-100 flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-violet-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900" id="stat-analyses">{{ count($recentAnalysis) }}</p>
                    <p class="text-xs text-gray-500 font-medium">Route Analyses</p>
                </div>
            </div>

            <div class="stat-card bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-emerald-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    @php
                        $avgSaved = count($recentAnalysis) > 0
                            ? collect($recentAnalysis)->avg(fn($a) => abs($a->estimated_time - $a->actual_time))
                            : 0;
                    @endphp
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($avgSaved, 1) }}<span class="text-sm font-normal text-gray-400">m</span></p>
                    <p class="text-xs text-gray-500 font-medium">Avg Time Saved</p>
                </div>
            </div>
        </div>

        {{-- Filter Bar --}}
        <div class="mb-4 flex flex-wrap items-center gap-2">
            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Filter:</span>
            <button onclick="filterTable('all')" data-filter="all"
                    class="filter-btn px-3 py-1.5 text-xs font-semibold rounded-lg bg-gray-900 text-white border border-gray-900 transition-all">All</button>
            <button onclick="filterTable('severe')" data-filter="severe"
                    class="filter-btn px-3 py-1.5 text-xs font-semibold rounded-lg bg-white text-red-700 border border-red-200 hover:bg-red-50 transition-all">🔴 Severe</button>
            <button onclick="filterTable('high')" data-filter="high"
                    class="filter-btn px-3 py-1.5 text-xs font-semibold rounded-lg bg-white text-orange-700 border border-orange-200 hover:bg-orange-50 transition-all">🟠 High</button>
            <button onclick="filterTable('moderate')" data-filter="moderate"
                    class="filter-btn px-3 py-1.5 text-xs font-semibold rounded-lg bg-white text-yellow-700 border border-yellow-200 hover:bg-yellow-50 transition-all">🟡 Moderate</button>
            <button onclick="filterTable('low')" data-filter="low"
                    class="filter-btn px-3 py-1.5 text-xs font-semibold rounded-lg bg-white text-emerald-700 border border-emerald-200 hover:bg-emerald-50 transition-all">🟢 Low</button>

            <div class="ml-auto flex items-center gap-1.5 text-xs text-gray-400">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 pulse"></span>
                Live · updated <span id="last-updated">just now</span>
            </div>
        </div>

        {{-- Active Vehicle Traffic Table --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center gap-3">
                <div class="flex items-center gap-2 flex-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <span class="text-sm font-semibold text-gray-700">Active Vehicle Traffic</span>
                    <span class="ml-1 px-2 py-0.5 text-xs font-semibold bg-amber-100 text-amber-700 rounded-full" id="table-badge">{{ count($activeTraffic) }}</span>
                </div>
                <div class="relative sm:w-64">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/>
                    </svg>
                    <input id="search-input" type="text" placeholder="Search route or vehicle..."
                           class="w-full pl-9 pr-3 py-2 text-sm bg-gray-50 border border-gray-200 rounded-lg text-gray-700 placeholder-gray-400 focus:bg-white transition-all duration-200">
                </div>
            </div>

            <div id="table-container">
                @include('traffic.partials.active-traffic-table', ['activeTraffic' => $activeTraffic])
            </div>

            <div class="px-6 py-3 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
                <p class="text-xs text-gray-400" id="row-count">Showing {{ count($activeTraffic) }} vehicle(s)</p>
                <p class="text-xs text-gray-400">Fleet Management System</p>
            </div>
        </div>

        {{-- Recent Trip Analyses --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-400">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span class="text-sm font-semibold text-gray-700">Recent Trip Analyses</span>
                <span class="ml-1 px-2 py-0.5 text-xs font-semibold bg-amber-100 text-amber-700 rounded-full">{{ count($recentAnalysis) }}</span>
            </div>

            @if(count($recentAnalysis) > 0)
                <div class="divide-y divide-gray-50">
                    @foreach($recentAnalysis as $analysis)
                        @php
                            $timeDiff = $analysis->actual_time - $analysis->estimated_time;
                            $faster = $timeDiff < 0;
                        @endphp
                        <div class="px-6 py-4 hover:bg-amber-50 transition-colors">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-900 truncate">{{ $analysis->original_route }}</p>
                                    <p class="text-xs text-gray-400 mt-0.5">Trip #{{ $analysis->trip_id }}</p>
                                </div>
                                <div class="flex items-center gap-2 flex-shrink-0">
                                    @if($faster)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-emerald-50 text-emerald-700 text-xs font-semibold rounded-full border border-emerald-200">
                                            ↓ {{ abs($timeDiff) }}min faster
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-red-50 text-red-700 text-xs font-semibold rounded-full border border-red-200">
                                            ↑ {{ abs($timeDiff) }}min slower
                                        </span>
                                    @endif
                                    <a href="{{ route('traffic.show-analysis', $analysis->trip) }}"
                                       class="action-btn inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-amber-700 bg-amber-50 hover:bg-amber-100 border border-amber-200 rounded-lg">
                                        View
                                    </a>
                                </div>
                            </div>
                            <div class="grid grid-cols-4 gap-3 mt-3">
                                <div class="bg-gray-50 rounded-lg px-3 py-2">
                                    <p class="text-xs text-gray-400">Avg Speed</p>
                                    <p class="text-sm font-semibold text-gray-900">{{ number_format($analysis->average_speed, 1) }} <span class="text-xs font-normal text-gray-400">km/h</span></p>
                                </div>
                                <div class="bg-gray-50 rounded-lg px-3 py-2">
                                    <p class="text-xs text-gray-400">Distance</p>
                                    <p class="text-sm font-semibold text-gray-900">{{ number_format($analysis->total_distance, 1) }} <span class="text-xs font-normal text-gray-400">km</span></p>
                                </div>
                                <div class="bg-gray-50 rounded-lg px-3 py-2">
                                    <p class="text-xs text-gray-400">Est. vs Actual</p>
                                    <p class="text-sm font-semibold {{ $faster ? 'text-emerald-600' : 'text-red-600' }}">{{ $analysis->estimated_time }}m / {{ $analysis->actual_time }}m</p>
                                </div>
                                <div class="bg-gray-50 rounded-lg px-3 py-2">
                                    <p class="text-xs text-gray-400">Congestion Pts</p>
                                    <p class="text-sm font-semibold text-gray-900">{{ count($analysis->congestion_segments ?? []) }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-16 px-4 text-center">
                    <div class="w-16 h-16 bg-amber-50 rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-amber-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold text-gray-700 mb-1">No analyses yet</h3>
                    <p class="text-gray-400 text-sm max-w-xs">Trip analyses will appear here once trips are completed.</p>
                </div>
            @endif
        </div>

    </div>
</div>

<script>
    // ── State ─────────────────────────────────────────────────────────────────
    const POLL_INTERVAL = 10000; // 10 seconds
    let currentFilter = 'all';
    let lastUpdatedSeconds = 0;
    let pollTimer = null;

    // ── Search ────────────────────────────────────────────────────────────────
    const searchInput = document.getElementById('search-input');
    searchInput && searchInput.addEventListener('input', applyFilters);

    // ── Filter buttons ────────────────────────────────────────────────────────
    function filterTable(level) {
        currentFilter = level;
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.classList.remove('bg-gray-900', 'text-white', 'border-gray-900');
            btn.classList.add('bg-white');
        });
        const activeBtn = document.querySelector(`[data-filter="${level}"]`);
        if (activeBtn) {
            activeBtn.classList.add('bg-gray-900', 'text-white', 'border-gray-900');
            activeBtn.classList.remove('bg-white');
        }
        applyFilters();
    }

    function applyFilters() {
        const query = (searchInput?.value || '').toLowerCase().trim();
        const rows  = document.querySelectorAll('#traffic-table tbody tr');
        let visible = 0;
        rows.forEach(row => {
            const route      = (row.dataset.route || '').toLowerCase();
            const congestion = row.dataset.congestion || '';
            const show = (!query || route.includes(query)) &&
                         (currentFilter === 'all' || congestion === currentFilter);
            row.style.display = show ? '' : 'none';
            if (show) visible++;
        });
        const rc = document.getElementById('row-count');
        if (rc) rc.textContent = `Showing ${visible} vehicle(s)`;
    }

    // ── Congestion badge helper ───────────────────────────────────────────────
    function congestionBadge(level) {
        const map = {
            severe:   'bg-red-50 text-red-700 border-red-200',
            high:     'bg-orange-50 text-orange-700 border-orange-200',
            moderate: 'bg-yellow-50 text-yellow-700 border-yellow-200',
            low:      'bg-emerald-50 text-emerald-700 border-emerald-200',
        };
        const dot = {
            severe:   'bg-red-500 pulse',
            high:     'bg-orange-500',
            moderate: 'bg-yellow-500',
            low:      'bg-emerald-500',
        };
        const cls   = map[level]  || map.low;
        const dcls  = dot[level]  || dot.low;
        const label = level.charAt(0).toUpperCase() + level.slice(1);
        return `<span class="inline-flex items-center gap-1.5 px-2.5 py-1 ${cls} text-xs font-semibold rounded-full border">
                    <span class="w-1.5 h-1.5 rounded-full ${dcls}"></span>${label}
                </span>`;
    }

    // ── Live poll ─────────────────────────────────────────────────────────────
    function pollActiveStatus() {
        fetch('{{ route("traffic.active-status") }}')
            .then(r => r.json())
            .then(json => {
                if (!json.success) return;
                updateDashboard(json.data);
                lastUpdatedSeconds = 0;
            })
            .catch(err => console.warn('Poll failed:', err));
    }

    function updateDashboard(vehicles) {
        // Update stat card
        const statEl = document.getElementById('stat-active');
        if (statEl && statEl.textContent != vehicles.length) {
            statEl.textContent = vehicles.length;
            statEl.classList.add('stat-updated');
            setTimeout(() => statEl.classList.remove('stat-updated'), 400);
        }

        const badge = document.getElementById('table-badge');
        if (badge) badge.textContent = vehicles.length;

        const container = document.getElementById('table-container');
        if (!container) return;

        if (vehicles.length === 0) {
            container.innerHTML = `
                <div class="flex flex-col items-center justify-center py-20 px-4 text-center">
                    <div class="w-20 h-20 bg-amber-50 rounded-full flex items-center justify-center mb-5">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-amber-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 17a2 2 0 104 0 2 2 0 00-4 0m8 0a2 2 0 104 0 2 2 0 00-4 0M3 7h2l2-4h10l2 4h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1V8a1 1 0 011-1z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">No active vehicles</h3>
                    <p class="text-gray-400 text-sm max-w-xs">Active trips will appear here in real time.</p>
                </div>`;
            document.getElementById('row-count').textContent = 'Showing 0 vehicle(s)';
            return;
        }

        // Build table rows
        const rows = vehicles.map(v => {
            const lat  = parseFloat(v.location?.latitude  || 0).toFixed(4);
            const lng  = parseFloat(v.location?.longitude || 0).toFixed(4);
            const speed = parseFloat(v.current_speed || 0).toFixed(1);
            const ts   = v.timestamp ? new Date(v.timestamp) : new Date();
            const ago  = timeAgo(ts);
            const mapsUrl = `https://www.google.com/maps?q=${lat},${lng}`;

            return `<tr class="traffic-row row-fade"
                        data-route="${(v.route || '').toLowerCase()}"
                        data-congestion="${v.congestion_level || 'low'}">
                <td class="px-6 py-4">
                    <span class="inline-flex items-center px-3 py-1 bg-amber-100 text-amber-700 text-xs font-semibold rounded-lg">#${v.trip_id}</span>
                </td>
                <td class="px-6 py-4">
                    <p class="text-sm font-medium text-gray-900">${v.route || 'Unknown route'}</p>
                </td>
                <td class="px-6 py-4">
                    <span class="text-sm font-semibold text-gray-900">${speed}</span>
                    <span class="text-xs text-gray-400 ml-0.5">km/h</span>
                </td>
                <td class="px-6 py-4">${congestionBadge(v.congestion_level || 'low')}</td>
                <td class="px-6 py-4">
                    <a href="${mapsUrl}" target="_blank"
                       class="inline-flex items-center gap-1 text-xs text-amber-600 hover:text-amber-800 font-mono hover:underline">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3.5 h-3.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                        </svg>
                        ${lat}, ${lng}
                    </a>
                </td>
                <td class="px-6 py-4 text-xs text-gray-500">${ago}</td>
                <td class="px-6 py-4 text-right">
                    <a href="/trips/${v.trip_id}"
                       class="action-btn inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-amber-700 bg-amber-50 hover:bg-amber-100 border border-amber-200 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3.5 h-3.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        View Trip
                    </a>
                </td>
            </tr>`;
        }).join('');

        container.innerHTML = `
            <div class="overflow-x-auto">
                <table class="w-full" id="traffic-table">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Trip</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Route</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Speed</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Congestion</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Coordinates</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Last Update</th>
                            <th class="text-right px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">${rows}</tbody>
                </table>
            </div>`;

        document.getElementById('row-count').textContent = `Showing ${vehicles.length} vehicle(s)`;
        applyFilters();
    }

    // ── Time ago helper ───────────────────────────────────────────────────────
    function timeAgo(date) {
        const seconds = Math.floor((new Date() - date) / 1000);
        if (seconds < 10)  return 'just now';
        if (seconds < 60)  return `${seconds} seconds ago`;
        if (seconds < 120) return '1 minute ago';
        if (seconds < 3600) return `${Math.floor(seconds / 60)} minutes ago`;
        return `${Math.floor(seconds / 3600)} hours ago`;
    }

    // ── Last updated ticker ───────────────────────────────────────────────────
    setInterval(() => {
        lastUpdatedSeconds++;
        const el = document.getElementById('last-updated');
        if (el) el.textContent = lastUpdatedSeconds < 5
            ? 'just now'
            : `${lastUpdatedSeconds}s ago`;
    }, 1000);

    // ── Manual refresh ────────────────────────────────────────────────────────
    function refreshData() {
        const icon = document.getElementById('refresh-icon');
        icon.classList.add('spin');
        pollActiveStatus();
        setTimeout(() => icon.classList.remove('spin'), 600);
    }

    // ── Start polling ─────────────────────────────────────────────────────────
    pollTimer = setInterval(pollActiveStatus, POLL_INTERVAL);

    // Stop polling when tab is hidden, resume when visible (saves resources)
    document.addEventListener('visibilitychange', () => {
        if (document.hidden) {
            clearInterval(pollTimer);
        } else {
            pollActiveStatus();
            pollTimer = setInterval(pollActiveStatus, POLL_INTERVAL);
        }
    });
</script>
@endsection