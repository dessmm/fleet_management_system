<!DOCTYPE html>
<html lang="en" class="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fleet Management System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* ══════════════════════════════════════════════════════════
           GLOBAL DARK MODE OVERRIDES
           ══════════════════════════════════════════════════════════ */

        /* ── Base ────────────────────────────────────────────────── */
        html.dark body                          { background: #0f172a; color: #e2e8f0; }
        html.dark *                             { border-color: #334155; }

        /* ── Backgrounds ─────────────────────────────────────────── */
        html.dark .bg-white                     { background: #1e293b !important; }
        html.dark .bg-gray-50                   { background: #0f172a !important; }
        html.dark .bg-gray-100                  { background: #1e293b !important; }
        html.dark .bg-gray-200                  { background: #334155 !important; }
        html.dark .bg-slate-50                  { background: #0f172a !important; }
        html.dark .bg-slate-100                 { background: #1e293b !important; }

        /* ── Gradient backgrounds ────────────────────────────────── */
        html.dark .bg-gradient-to-br.from-slate-50  { --tw-gradient-from: #0f172a; }
        html.dark .bg-gradient-to-br.via-blue-50    { --tw-gradient-via: #0f172a; }
        html.dark .bg-gradient-to-br.via-indigo-50  { --tw-gradient-via: #0f172a; }
        html.dark .bg-gradient-to-br.via-purple-50  { --tw-gradient-via: #0f172a; }
        html.dark .bg-gradient-to-br.via-red-50     { --tw-gradient-via: #0f172a; }
        html.dark .bg-gradient-to-br.via-orange-50  { --tw-gradient-via: #0f172a; }
        html.dark .bg-gradient-to-br.via-amber-50   { --tw-gradient-via: #0f172a; }
        html.dark .bg-gradient-to-br.to-slate-100   { --tw-gradient-to: #1e293b; }
        html.dark .min-h-screen                 { background: #0f172a; }

        /* ── Text ────────────────────────────────────────────────── */
        html.dark .text-gray-900               { color: #f1f5f9 !important; }
        html.dark .text-gray-800               { color: #e2e8f0 !important; }
        html.dark .text-gray-700               { color: #cbd5e1 !important; }
        html.dark .text-gray-600               { color: #94a3b8 !important; }
        html.dark .text-gray-500               { color: #64748b !important; }
        html.dark .text-gray-400               { color: #475569 !important; }

        /* ── Borders ─────────────────────────────────────────────── */
        html.dark .border-gray-100             { border-color: #334155 !important; }
        html.dark .border-gray-200             { border-color: #334155 !important; }
        html.dark .border-gray-300             { border-color: #475569 !important; }
        html.dark .divide-gray-50 > *          { border-color: #334155 !important; }
        html.dark .divide-gray-100 > *         { border-color: #334155 !important; }
        html.dark .divide-y > *                { border-color: #334155 !important; }

        /* ── Cards & Panels ──────────────────────────────────────── */
        html.dark .rounded-2xl.bg-white        { background: #1e293b !important; }
        html.dark .rounded-xl.bg-white         { background: #1e293b !important; }
        html.dark .shadow-sm                   { box-shadow: 0 1px 3px rgba(0,0,0,.4) !important; }

        /* ── Inputs & Selects ────────────────────────────────────── */
        html.dark input,
        html.dark select,
        html.dark textarea                      { background: #0f172a !important; color: #e2e8f0 !important; border-color: #334155 !important; }
        html.dark input::placeholder,
        html.dark textarea::placeholder         { color: #475569 !important; }
        html.dark input:focus,
        html.dark select:focus,
        html.dark textarea:focus                { background: #1e293b !important; }

        /* ── Tables ──────────────────────────────────────────────── */
        html.dark table                         { background: #1e293b; }
        html.dark thead tr                      { background: #0f172a !important; }
        html.dark tbody tr:hover                { background: #334155 !important; }
        html.dark .bg-gray-50.border-b          { background: #0f172a !important; }
        html.dark th                            { color: #94a3b8 !important; }
        html.dark td                            { color: #cbd5e1; }

        /* ── Buttons ─────────────────────────────────────────────── */
        html.dark .hover\:bg-gray-50:hover      { background: #334155 !important; }
        html.dark .hover\:bg-gray-100:hover     { background: #334155 !important; }

        /* ── Stat / Side cards ───────────────────────────────────── */
        html.dark .stat-card                    { background: #1e293b !important; border-color: #334155 !important; }
        html.dark .side-card                    { background: #1e293b !important; border-color: #334155 !important; }

        /* ── Info cells ──────────────────────────────────────────── */
        html.dark .info-cell                    { background: #1e293b; }
        html.dark .info-cell:hover              { background: #334155 !important; }

        /* ── Table row hovers ────────────────────────────────────── */
        html.dark .vehicle-row:hover            { background: #334155 !important; }
        html.dark .driver-row:hover             { background: #334155 !important; }
        html.dark .trip-row:hover               { background: #334155 !important; }
        html.dark .maintenance-row:hover        { background: #334155 !important; }
        html.dark .fuel-row:hover               { background: #334155 !important; }
        html.dark .traffic-row:hover            { background: #334155 !important; }

        /* ── Colored badge backgrounds ───────────────────────────── */
        html.dark .bg-blue-100                  { background: #1e3a5f !important; }
        html.dark .bg-indigo-100                { background: #1e1b4b !important; }
        html.dark .bg-violet-100                { background: #2e1065 !important; }
        html.dark .bg-purple-100                { background: #2e1065 !important; }
        html.dark .bg-emerald-100               { background: #064e3b !important; }
        html.dark .bg-red-100                   { background: #450a0a !important; }
        html.dark .bg-amber-100                 { background: #431407 !important; }
        html.dark .bg-orange-100                { background: #431407 !important; }
        html.dark .bg-yellow-100                { background: #422006 !important; }

        /* ── Colored badge text ──────────────────────────────────── */
        html.dark .text-blue-700                { color: #93c5fd !important; }
        html.dark .text-indigo-700              { color: #a5b4fc !important; }
        html.dark .text-violet-700              { color: #c4b5fd !important; }
        html.dark .text-purple-700              { color: #c4b5fd !important; }
        html.dark .text-emerald-700             { color: #6ee7b7 !important; }
        html.dark .text-red-700                 { color: #fca5a5 !important; }
        html.dark .text-amber-700               { color: #fcd34d !important; }
        html.dark .text-orange-700              { color: #fdba74 !important; }

        /* ── Light tinted section backgrounds ───────────────────── */
        html.dark .bg-blue-50                   { background: #172554 !important; }
        html.dark .bg-indigo-50                 { background: #1e1b4b !important; }
        html.dark .bg-violet-50                 { background: #2e1065 !important; }
        html.dark .bg-purple-50                 { background: #2e1065 !important; }
        html.dark .bg-emerald-50                { background: #022c22 !important; }
        html.dark .bg-red-50                    { background: #450a0a !important; }
        html.dark .bg-amber-50                  { background: #431407 !important; }
        html.dark .bg-orange-50                 { background: #431407 !important; }

        /* ── Gradient hero banners ───────────────────────────────── */
        html.dark .bg-gradient-to-r.from-blue-600   { opacity: 0.9; }
        html.dark .bg-gradient-to-r.from-indigo-600 { opacity: 0.9; }
        html.dark .bg-gradient-to-r.from-purple-600 { opacity: 0.9; }
        html.dark .bg-gradient-to-r.from-red-600    { opacity: 0.9; }
        html.dark .bg-gradient-to-r.from-orange-600 { opacity: 0.9; }
        html.dark .bg-gradient-to-r.from-amber-500  { opacity: 0.9; }

        /* ── Modals ──────────────────────────────────────────────── */
        html.dark #delete-modal .bg-white,
        html.dark #del-modal .bg-white,
        html.dark #route-modal .bg-white,
        html.dark #jsonModal .bg-white          { background: #1e293b !important; }
        html.dark #delete-modal .text-gray-900,
        html.dark #del-modal .text-gray-900,
        html.dark #route-modal .text-gray-900   { color: #f1f5f9 !important; }
        html.dark #delete-modal .text-gray-500,
        html.dark #del-modal .text-gray-500,
        html.dark #route-modal .text-gray-500   { color: #94a3b8 !important; }

        /* ── Search inputs ───────────────────────────────────────── */
        html.dark #search-input                 { background: #0f172a !important; color: #e2e8f0 !important; border-color: #334155 !important; }
        html.dark #search-input:focus           { background: #1e293b !important; box-shadow: 0 0 0 3px rgba(99,102,241,.2) !important; }

        /* ── Notification panel ──────────────────────────────────── */
        html.dark #notif-panel                  { background: #1e293b !important; border-color: #334155 !important; }
        html.dark .notif-item:hover             { background: #334155 !important; }

        /* ── Navbar ──────────────────────────────────────────────── */
        html.dark nav                           { background: #1e293b !important; border-color: #334155 !important; }
        html.dark .nav-link.active              { background: #1e3a5f !important; color: #93c5fd !important; }
        html.dark .nav-link:hover               { background: #334155 !important; }
        html.dark #mobile-menu                  { background: #1e293b !important; border-color: #334155 !important; }
        html.dark #mobile-menu a                { color: #cbd5e1; }
        html.dark #mobile-menu a:hover          { background: #334155 !important; color: #f1f5f9 !important; }

        /* ── Footer ──────────────────────────────────────────────── */
        html.dark footer                        { background: #020617 !important; border-color: #1e293b !important; }

        /* ── Toast ───────────────────────────────────────────────── */
        html.dark .toast                        { background: #1e293b !important; border-color: #334155 !important; }
        html.dark .toast-title                  { color: #f1f5f9 !important; }
        html.dark .toast-msg                    { color: #94a3b8 !important; }
        html.dark .toast-close                  { color: #64748b !important; }
        html.dark .toast-close:hover            { color: #cbd5e1 !important; }

        /* ── Leaflet map ─────────────────────────────────────────── */
        html.dark .leaflet-container            { background: #1e293b; }
        html.dark .leaflet-popup-content-wrapper { background: #1e293b !important; color: #e2e8f0 !important; border: 1px solid #334155; }
        html.dark .leaflet-popup-tip            { background: #1e293b !important; }

        /* ── Custom scrollbar ────────────────────────────────────── */
        html.dark ::-webkit-scrollbar           { width: 6px; height: 6px; }
        html.dark ::-webkit-scrollbar-track     { background: #0f172a; }
        html.dark ::-webkit-scrollbar-thumb     { background: #334155; border-radius: 3px; }
        html.dark ::-webkit-scrollbar-thumb:hover { background: #475569; }

        /* ══════════════════════════════════════════════════════════
           TOAST NOTIFICATIONS
           ══════════════════════════════════════════════════════════ */
        #toast-container { position: fixed; top: 1.25rem; right: 1.25rem; z-index: 9999; display: flex; flex-direction: column; gap: .625rem; pointer-events: none; }
        .toast { display: flex; align-items: flex-start; gap: .75rem; padding: .875rem 1rem; background: #fff; border-radius: .875rem; box-shadow: 0 8px 32px rgba(0,0,0,.12), 0 2px 8px rgba(0,0,0,.08); border: 1px solid #e5e7eb; min-width: 280px; max-width: 380px; pointer-events: all; transform: translateX(120%); opacity: 0; transition: transform .35s cubic-bezier(.34,1.56,.64,1), opacity .35s ease; }
        .toast.show { transform: translateX(0); opacity: 1; }
        .toast.hide { transform: translateX(120%); opacity: 0; }
        .toast-icon { width: 2rem; height: 2rem; border-radius: .5rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .toast-title { font-size: .8125rem; font-weight: 700; color: #111827; line-height: 1.2; }
        .toast-msg { font-size: .75rem; color: #6b7280; margin-top: .125rem; line-height: 1.4; }
        .toast-close { margin-left: auto; flex-shrink: 0; background: none; border: none; color: #9ca3af; cursor: pointer; font-size: 1rem; line-height: 1; padding: .125rem; transition: color .15s; }
        .toast-close:hover { color: #374151; }
        .toast-progress { position: absolute; bottom: 0; left: 0; height: 3px; border-radius: 0 0 .875rem .875rem; animation: toast-progress linear forwards; }
        .toast { position: relative; overflow: hidden; }
        @keyframes toast-progress { from { width: 100%; } to { width: 0%; } }

        /* ══════════════════════════════════════════════════════════
           BELL DROPDOWN
           ══════════════════════════════════════════════════════════ */
        #notif-panel { transform-origin: top right; transition: transform .2s cubic-bezier(.34,1.56,.64,1), opacity .2s ease; }
        #notif-panel.hidden { transform: scale(.95); opacity: 0; pointer-events: none; }
        #notif-panel:not(.hidden) { transform: scale(1); opacity: 1; }
        .notif-item { transition: background .15s; }
        .notif-item:hover { background: #f9fafb; }

        /* ══════════════════════════════════════════════════════════
           NAVBAR ACTIVE LINK
           ══════════════════════════════════════════════════════════ */
        .nav-link.active { background: #eff6ff; color: #2563eb; }

        /* ══════════════════════════════════════════════════════════
           MOBILE MENU ANIMATION
           ══════════════════════════════════════════════════════════ */
        #mobile-menu { transition: max-height .3s ease, opacity .3s ease; max-height: 0; opacity: 0; overflow: hidden; }
        #mobile-menu.open { max-height: 500px; opacity: 1; }

        /* ── Remove colored shadows in dark mode ─────────────────── */
html.dark .shadow-blue-200    { --tw-shadow-color: transparent !important; box-shadow: 0 4px 12px rgba(0,0,0,.4) !important; }
html.dark .shadow-indigo-200  { --tw-shadow-color: transparent !important; box-shadow: 0 4px 12px rgba(0,0,0,.4) !important; }
html.dark .shadow-violet-200  { --tw-shadow-color: transparent !important; box-shadow: 0 4px 12px rgba(0,0,0,.4) !important; }
html.dark .shadow-purple-200  { --tw-shadow-color: transparent !important; box-shadow: 0 4px 12px rgba(0,0,0,.4) !important; }
html.dark .shadow-red-200     { --tw-shadow-color: transparent !important; box-shadow: 0 4px 12px rgba(0,0,0,.4) !important; }
html.dark .shadow-orange-200  { --tw-shadow-color: transparent !important; box-shadow: 0 4px 12px rgba(0,0,0,.4) !important; }
html.dark .shadow-amber-200   { --tw-shadow-color: transparent !important; box-shadow: 0 4px 12px rgba(0,0,0,.4) !important; }
html.dark .shadow-emerald-200 { --tw-shadow-color: transparent !important; box-shadow: 0 4px 12px rgba(0,0,0,.4) !important; }
html.dark .shadow-green-200   { --tw-shadow-color: transparent !important; box-shadow: 0 4px 12px rgba(0,0,0,.4) !important; }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-gray-50 transition-colors duration-300">

    {{-- ── NAVBAR ──────────────────────────────────────────────── --}}
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
        <style>
            @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&display=swap');
            nav * { font-family: 'DM Sans', sans-serif; }
            .nav-link { padding: .5rem .875rem; border-radius: 10px; font-size: .85rem; font-weight: 500; color: #6b7280; transition: all .2s ease; }
            .nav-link:hover { background: #f3f4f6; color: #374151; }
            .nav-link.active { background: #eff6ff; color: #2563eb; font-weight: 600; }
        </style>
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between h-16">

                {{-- Logo --}}
                <a href="/" class="flex items-center gap-3 hover:opacity-80 transition-opacity">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-md">🚛</div>
                    <span class="text-lg font-bold text-gray-900 hidden sm:inline" style="letter-spacing: -.5px;">Fleet Manager</span>
                </a>

                {{-- Desktop Nav links --}}
                <ul class="hidden md:flex items-center gap-2">
                    @php
                        $navLinks = [
                            ['route' => 'vehicles.index',            'label' => 'Vehicles',    'icon' => '🚗'],
                            ['route' => 'drivers.index',             'label' => 'Drivers',     'icon' => '👨‍💼'],
                            ['route' => 'trips.index',               'label' => 'Trips',       'icon' => '📍'],
                            ['route' => 'maintenance_records.index', 'label' => 'Maintenance', 'icon' => '🔧'],
                            ['route' => 'fuel_records.index',        'label' => 'Fuel',        'icon' => '⛽'],
                            ['route' => 'traffic.dashboard',         'label' => 'Traffic',     'icon' => '📊'],
                        ];
                    @endphp
                    @foreach($navLinks as $link)
                        <li>
                            <a href="{{ route($link['route']) }}"
                               class="nav-link {{ request()->routeIs(explode('.', $link['route'])[0].'.*') ? 'active' : '' }}">
                                {{ $link['icon'] }} <span class="hidden lg:inline">{{ $link['label'] }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>

                {{-- Right side: Dark Mode + Bell + Home + Hamburger --}}
                <div class="flex items-center gap-3">

                    {{-- Dark Mode Toggle --}}
                    <button id="dark-toggle" onclick="toggleDarkMode()"
                            class="w-10 h-10 flex items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 transition-colors duration-200"
                            title="Toggle dark mode">
                        <svg id="icon-sun" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                        </svg>
                        <svg id="icon-moon" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                    </button>

                    {{-- Bell Button --}}
                    <div class="relative">
                        <button id="bell-btn" onclick="toggleNotifPanel()"
                                class="relative w-10 h-10 flex items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            @php
                                $alerts = [];
                                try {
                                    $expiringDrivers = \App\Models\Driver::whereNotNull('license_expiry_date')
                                        ->where('license_expiry_date', '<=', now()->addDays(30))->get();
                                    foreach ($expiringDrivers as $driver) {
                                        $expired = $driver->license_expiry_date->isPast();
                                        $alerts[] = ['type' => $expired ? 'error' : 'warning', 'title' => $expired ? 'License Expired' : 'License Expiring Soon', 'message' => $driver->name . ' — ' . $driver->license_expiry_date->format('M d, Y'), 'link' => route('drivers.show', $driver->id)];
                                    }
                                } catch (\Exception $e) {}
                                try {
                                    $overdueVehicles = \App\Models\MaintenanceRecord::with('vehicle')->where('service_date', '<=', now()->subDays(90))->orderByDesc('service_date')->get()->unique('vehicle_id')->take(5);
                                    foreach ($overdueVehicles as $record) {
                                        $alerts[] = ['type' => 'warning', 'title' => 'Maintenance Overdue', 'message' => ($record->vehicle->plate_number ?? 'Vehicle') . ' — last serviced ' . $record->service_date->diffForHumans(), 'link' => route('maintenance_records.index')];
                                    }
                                } catch (\Exception $e) {}
                                try {
                                    $activeTrips = \App\Models\Trip::where('status', 'in_progress')->count();
                                    if ($activeTrips > 0) {
                                        $alerts[] = ['type' => 'info', 'title' => 'Active Trips', 'message' => $activeTrips . ' trip' . ($activeTrips > 1 ? 's' : '') . ' currently in progress', 'link' => route('trips.index')];
                                    }
                                } catch (\Exception $e) {}
                                $alertCount = count($alerts);
                            @endphp
                            @if($alertCount > 0)
                                <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center leading-none">
                                    {{ $alertCount > 9 ? '9+' : $alertCount }}
                                </span>
                            @endif
                        </button>

                        {{-- Notification Panel --}}
                        <div id="notif-panel" class="hidden absolute right-0 mt-3 w-96 bg-white rounded-2xl shadow-2xl border border-gray-200 overflow-hidden" style="top: 100%;">
                            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-bold text-gray-900">Notifications</span>
                                    @if($alertCount > 0)
                                        <span class="px-2 py-0.5 text-xs font-semibold bg-red-100 text-red-700 rounded-full">{{ $alertCount }}</span>
                                    @endif
                                </div>
                                @if($alertCount > 0)
                                    <button onclick="clearAllNotifs()" class="text-xs text-gray-400 hover:text-gray-600 font-medium transition-colors">Clear all</button>
                                @endif
                            </div>
                            <div id="notif-list" class="divide-y divide-gray-100 max-h-96 overflow-y-auto">
                                @if($alertCount > 0)
                                    @foreach($alerts as $i => $alert)
                                        <div class="notif-item px-6 py-4 cursor-pointer hover:bg-gray-50 transition-colors" id="notif-{{ $i }}" onclick="window.location='{{ $alert['link'] }}'">
                                            <div class="flex items-start gap-3">
                                                <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5 {{ $alert['type'] === 'error' ? 'bg-red-100' : ($alert['type'] === 'warning' ? 'bg-amber-100' : 'bg-blue-100') }}">
                                                    @if($alert['type'] === 'error')
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z"/></svg>
                                                    @elseif($alert['type'] === 'warning')
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z"/></svg>
                                                    @else
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                    @endif
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-xs font-bold text-gray-900">{{ $alert['title'] }}</p>
                                                    <p class="text-xs text-gray-500 mt-0.5 truncate">{{ $alert['message'] }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="px-6 py-12 text-center">
                                        <div class="w-14 h-14 bg-gray-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                                        </div>
                                        <p class="text-sm font-bold text-gray-500">All clear!</p>
                                        <p class="text-xs text-gray-400 mt-1">No alerts at this time</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Home button (hidden on mobile) --}}
                    <a href="/" class="hidden sm:inline-flex px-5 py-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg text-sm font-semibold hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
                        🏠 Home
                    </a>

                    {{-- Hamburger (mobile only) --}}
                    <button id="hamburger" onclick="toggleMobileMenu()"
                            class="md:hidden w-10 h-10 flex items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 transition-colors duration-200">
                        <svg id="hamburger-icon" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <svg id="close-icon" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- ── MOBILE MENU ──────────────────────────────────────── --}}
        <div id="mobile-menu" class="md:hidden border-t border-gray-100 bg-white">
            <div class="container mx-auto px-4 py-4 space-y-2">
                @foreach($navLinks as $link)
                    <a href="{{ route($link['route']) }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-100 transition-colors {{ request()->routeIs(explode('.', $link['route'])[0].'.*') ? 'bg-blue-50 text-blue-700' : '' }}">
                        <span class="text-lg">{{ $link['icon'] }}</span>
                        {{ $link['label'] }}
                    </a>
                @endforeach
                <div class="border-t border-gray-100 pt-3 mt-3">
                    <a href="/" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-blue-700">
                        🏠 Home
                    </a>
                </div>
            </div>
        </div>
    </nav>

    {{-- ── TOAST CONTAINER ─────────────────────────────────────── --}}
    <div id="toast-container"></div>

    <main>
        @yield('content')
    </main>

    <footer class="bg-gray-900 text-gray-400 mt-20 border-t border-gray-800">
        <div class="container mx-auto px-4 py-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h3 class="text-white font-semibold mb-4">Fleet Manager</h3>
                    <p class="text-sm">Complete fleet management solution for modern logistics.</p>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Navigation</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('vehicles.index') }}" class="hover:text-white transition-colors duration-200">Vehicles</a></li>
                        <li><a href="{{ route('drivers.index') }}" class="hover:text-white transition-colors duration-200">Drivers</a></li>
                        <li><a href="{{ route('trips.index') }}" class="hover:text-white transition-colors duration-200">Trips</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Operations</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('maintenance_records.index') }}" class="hover:text-white transition-colors duration-200">Maintenance</a></li>
                        <li><a href="{{ route('fuel_records.index') }}" class="hover:text-white transition-colors duration-200">Fuel Records</a></li>
                        <li><a href="{{ route('traffic.dashboard') }}" class="hover:text-white transition-colors duration-200">Traffic Control</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Contact</h4>
                    <p class="text-sm mb-2">Email: support@fleetmanager.com</p>
                    <p class="text-sm">Phone: (555) 123-4567</p>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-sm">
                <p>&copy; 2026 Fleet Management System. All rights reserved.</p>
            </div>
        </div>
    </footer>

    {{-- ── GLOBAL SCRIPTS ───────────────────────────────────────── --}}
    <script>
        // ── Dark Mode ─────────────────────────────────────────────
        const html     = document.documentElement;
        const iconSun  = document.getElementById('icon-sun');
        const iconMoon = document.getElementById('icon-moon');

        function applyDark(dark) {
            if (dark) {
                html.classList.add('dark');
                iconSun.classList.remove('hidden');
                iconMoon.classList.add('hidden');
            } else {
                html.classList.remove('dark');
                iconSun.classList.add('hidden');
                iconMoon.classList.remove('hidden');
            }
        }

        function toggleDarkMode() {
            const isDark = html.classList.contains('dark');
            localStorage.setItem('darkMode', !isDark);
            applyDark(!isDark);
        }

        applyDark(localStorage.getItem('darkMode') === 'true');

        // ── Mobile Menu ───────────────────────────────────────────
        let mobileOpen = false;

        function toggleMobileMenu() {
            mobileOpen = !mobileOpen;
            const menu          = document.getElementById('mobile-menu');
            const hamburgerIcon = document.getElementById('hamburger-icon');
            const closeIcon     = document.getElementById('close-icon');
            if (mobileOpen) {
                menu.classList.add('open');
                hamburgerIcon.classList.add('hidden');
                closeIcon.classList.remove('hidden');
            } else {
                menu.classList.remove('open');
                hamburgerIcon.classList.remove('hidden');
                closeIcon.classList.add('hidden');
            }
        }

        document.addEventListener('click', function(e) {
            const nav = document.getElementById('mobile-menu');
            const btn = document.getElementById('hamburger');
            if (mobileOpen && !nav.contains(e.target) && !btn.contains(e.target)) {
                toggleMobileMenu();
            }
        });

        // ── Toast System ──────────────────────────────────────────
        const toastColors = {
            success: { bg: '#f0fdf4', border: '#bbf7d0', icon: '#16a34a', progress: '#16a34a', title: 'Success' },
            error:   { bg: '#fef2f2', border: '#fecaca', icon: '#dc2626', progress: '#dc2626', title: 'Error'   },
            warning: { bg: '#fffbeb', border: '#fde68a', icon: '#d97706', progress: '#d97706', title: 'Warning' },
            info:    { bg: '#eff6ff', border: '#bfdbfe', icon: '#2563eb', progress: '#2563eb', title: 'Info'    },
        };

        function showToast(type, message, duration = 4500) {
            const c  = toastColors[type] || toastColors.info;
            const id = 'toast-' + Date.now();
            const icons = {
                success: `<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>`,
                error:   `<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>`,
                warning: `<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z"/></svg>`,
                info:    `<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`,
            };
            const el = document.createElement('div');
            el.className = 'toast';
            el.id = id;
            el.style.background  = c.bg;
            el.style.borderColor = c.border;
            el.innerHTML = `
                <div class="toast-icon" style="background:${c.icon}20; color:${c.icon}">${icons[type]}</div>
                <div class="flex-1 min-w-0">
                    <p class="toast-title">${c.title}</p>
                    <p class="toast-msg">${message}</p>
                </div>
                <button class="toast-close" onclick="dismissToast('${id}')">&times;</button>
                <div class="toast-progress" style="background:${c.progress}; animation-duration:${duration}ms;"></div>
            `;
            document.getElementById('toast-container').appendChild(el);
            requestAnimationFrame(() => { requestAnimationFrame(() => el.classList.add('show')); });
            setTimeout(() => dismissToast(id), duration);
        }

        function dismissToast(id) {
            const el = document.getElementById(id);
            if (!el) return;
            el.classList.remove('show');
            el.classList.add('hide');
            setTimeout(() => el.remove(), 350);
        }

        @if(session('success')) showToast('success', @json(session('success'))); @endif
        @if(session('error'))   showToast('error',   @json(session('error')));   @endif
        @if(session('warning')) showToast('warning', @json(session('warning'))); @endif
        @if(session('info'))    showToast('info',    @json(session('info')));     @endif

        // ── Bell / Notification Panel ──────────────────────────────
        let notifOpen = false;

        function toggleNotifPanel() {
            const panel = document.getElementById('notif-panel');
            notifOpen = !notifOpen;
            notifOpen ? panel.classList.remove('hidden') : panel.classList.add('hidden');
        }

        function clearAllNotifs() {
            document.getElementById('notif-list').innerHTML = `
                <div class="px-4 py-10 text-center">
                    <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    </div>
                    <p class="text-sm font-semibold text-gray-500">All clear!</p>
                    <p class="text-xs text-gray-400 mt-1">No alerts right now</p>
                </div>`;
            const badge = document.querySelector('#bell-btn span');
            if (badge) badge.remove();
        }

        document.addEventListener('click', function(e) {
            const bell  = document.getElementById('bell-btn');
            const panel = document.getElementById('notif-panel');
            if (notifOpen && !bell.contains(e.target) && !panel.contains(e.target)) {
                panel.classList.add('hidden');
                notifOpen = false;
            }
        });

        // ── Active nav highlight ───────────────────────────────────
        document.querySelectorAll('.nav-link').forEach(link => {
            if (link.href === window.location.href || window.location.pathname.startsWith(new URL(link.href).pathname)) {
                link.classList.add('active');
            }
        });
    </script>
</body>
</html>