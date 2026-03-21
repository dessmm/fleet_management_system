<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fleet Management System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* ── Toast Notifications ─────────────────────────── */
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

        /* ── Bell dropdown ───────────────────────────────── */
        #notif-panel { transform-origin: top right; transition: transform .2s cubic-bezier(.34,1.56,.64,1), opacity .2s ease; }
        #notif-panel.hidden { transform: scale(.95); opacity: 0; pointer-events: none; }
        #notif-panel:not(.hidden) { transform: scale(1); opacity: 1; }
        .notif-item { transition: background .15s; }
        .notif-item:hover { background: #f9fafb; }

        /* ── Navbar active link ──────────────────────────── */
        .nav-link.active { background: #eff6ff; color: #2563eb; }
    </style>
</head>
<body class="bg-gray-50">

    {{-- ── NAVBAR ──────────────────────────────────────────────── --}}
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between h-16">

                {{-- Logo --}}
                <a href="/" class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-blue-700 rounded-lg flex items-center justify-center text-white font-bold text-lg">🚛</div>
                    <span class="text-xl font-bold text-gray-900 hidden sm:inline">Fleet Manager</span>
                </a>

                {{-- Nav links --}}
                <ul class="hidden md:flex items-center gap-1">
                    @php
                        $navLinks = [
                            ['route' => 'vehicles.index',            'label' => 'Vehicles',     'icon' => '🚗'],
                            ['route' => 'drivers.index',             'label' => 'Drivers',      'icon' => '👨‍💼'],
                            ['route' => 'trips.index',               'label' => 'Trips',        'icon' => '📍'],
                            ['route' => 'maintenance_records.index', 'label' => 'Maintenance',  'icon' => '🔧'],
                            ['route' => 'fuel_records.index',        'label' => 'Fuel',         'icon' => '⛽'],
                            ['route' => 'traffic.dashboard',         'label' => 'Traffic',      'icon' => '📊'],
                        ];
                    @endphp
                    @foreach($navLinks as $link)
                        <li>
                            <a href="{{ route($link['route']) }}"
                               class="nav-link px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-100 transition-colors duration-200 {{ request()->routeIs(explode('.', $link['route'])[0].'.*') ? 'active' : '' }}">
                                {{ $link['icon'] }} {{ $link['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                {{-- Right side: Bell + Home --}}
                <div class="flex items-center gap-2">

                    {{-- Bell Button --}}
                    <div class="relative">
                        <button id="bell-btn" onclick="toggleNotifPanel()"
                                class="relative w-10 h-10 flex items-center justify-center rounded-xl text-gray-500 hover:bg-gray-100 transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            {{-- Unread badge --}}
                            @php
                                $alerts = [];

                                // License expiry alerts
                                try {
                                    $expiringDrivers = \App\Models\Driver::whereNotNull('license_expiry_date')
                                        ->where('license_expiry_date', '<=', now()->addDays(30))
                                        ->get();
                                    foreach ($expiringDrivers as $driver) {
                                        $expired = $driver->license_expiry_date->isPast();
                                        $alerts[] = [
                                            'type'    => $expired ? 'error' : 'warning',
                                            'title'   => $expired ? 'License Expired' : 'License Expiring Soon',
                                            'message' => $driver->name . ' — ' . $driver->license_expiry_date->format('M d, Y'),
                                            'link'    => route('drivers.show', $driver->id),
                                        ];
                                    }
                                } catch (\Exception $e) {}

                                // Maintenance alerts — records older than 90 days
                                try {
                                    $overdueVehicles = \App\Models\MaintenanceRecord::with('vehicle')
                                        ->where('service_date', '<=', now()->subDays(90))
                                        ->orderByDesc('service_date')
                                        ->get()
                                        ->unique('vehicle_id')
                                        ->take(5);
                                    foreach ($overdueVehicles as $record) {
                                        $alerts[] = [
                                            'type'    => 'warning',
                                            'title'   => 'Maintenance Overdue',
                                            'message' => ($record->vehicle->plate_number ?? 'Vehicle') . ' — last serviced ' . $record->service_date->diffForHumans(),
                                            'link'    => route('maintenance_records.index'),
                                        ];
                                    }
                                } catch (\Exception $e) {}

                                // In-progress trips
                                try {
                                    $activeTrips = \App\Models\Trip::where('status', 'in_progress')->count();
                                    if ($activeTrips > 0) {
                                        $alerts[] = [
                                            'type'    => 'info',
                                            'title'   => 'Active Trips',
                                            'message' => $activeTrips . ' trip' . ($activeTrips > 1 ? 's' : '') . ' currently in progress',
                                            'link'    => route('trips.index'),
                                        ];
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
                        <div id="notif-panel" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden" style="top: 100%;">
                            <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-bold text-gray-900">Notifications</span>
                                    @if($alertCount > 0)
                                        <span class="px-2 py-0.5 text-xs font-semibold bg-red-100 text-red-700 rounded-full">{{ $alertCount }}</span>
                                    @endif
                                </div>
                                @if($alertCount > 0)
                                    <button onclick="clearAllNotifs()" class="text-xs text-gray-400 hover:text-gray-600 transition-colors">Clear all</button>
                                @endif
                            </div>

                            <div id="notif-list" class="divide-y divide-gray-50 max-h-80 overflow-y-auto">
                                @if($alertCount > 0)
                                    @foreach($alerts as $i => $alert)
                                        <div class="notif-item px-4 py-3 cursor-pointer" id="notif-{{ $i }}" onclick="window.location='{{ $alert['link'] }}'">
                                            <div class="flex items-start gap-3">
                                                <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5
                                                    {{ $alert['type'] === 'error' ? 'bg-red-100' : ($alert['type'] === 'warning' ? 'bg-amber-100' : 'bg-blue-100') }}">
                                                    @if($alert['type'] === 'error')
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z"/>
                                                        </svg>
                                                    @elseif($alert['type'] === 'warning')
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z"/>
                                                        </svg>
                                                    @else
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        </svg>
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
                                    <div class="px-4 py-10 text-center">
                                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                            </svg>
                                        </div>
                                        <p class="text-sm font-semibold text-gray-500">All clear!</p>
                                        <p class="text-xs text-gray-400 mt-1">No alerts right now</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Home button --}}
                    <a href="/" class="px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg text-sm font-semibold hover:shadow-lg transition-all duration-300">
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
        // ── Toast System ──────────────────────────────────────────
        const toastColors = {
            success: { bg: '#f0fdf4', border: '#bbf7d0', icon: '#16a34a', progress: '#16a34a', title: 'Success' },
            error:   { bg: '#fef2f2', border: '#fecaca', icon: '#dc2626', progress: '#dc2626', title: 'Error'   },
            warning: { bg: '#fffbeb', border: '#fde68a', icon: '#d97706', progress: '#d97706', title: 'Warning' },
            info:    { bg: '#eff6ff', border: '#bfdbfe', icon: '#2563eb', progress: '#2563eb', title: 'Info'    },
        };

        function showToast(type, message, duration = 4500) {
            const c = toastColors[type] || toastColors.info;
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
            el.style.background = c.bg;
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

        // ── Auto-fire flash messages as toasts ────────────────────
        @if(session('success'))
            showToast('success', @json(session('success')));
        @endif
        @if(session('error'))
            showToast('error', @json(session('error')));
        @endif
        @if(session('warning'))
            showToast('warning', @json(session('warning')));
        @endif
        @if(session('info'))
            showToast('info', @json(session('info')));
        @endif

        // ── Bell / Notification Panel ──────────────────────────────
        let notifOpen = false;

        function toggleNotifPanel() {
            const panel = document.getElementById('notif-panel');
            notifOpen = !notifOpen;
            if (notifOpen) {
                panel.classList.remove('hidden');
            } else {
                panel.classList.add('hidden');
            }
        }

        function clearAllNotifs() {
            document.getElementById('notif-list').innerHTML = `
                <div class="px-4 py-10 text-center">
                    <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-gray-500">All clear!</p>
                    <p class="text-xs text-gray-400 mt-1">No alerts right now</p>
                </div>`;
            const badge = document.querySelector('#bell-btn span');
            if (badge) badge.remove();
        }

        // Close panel when clicking outside
        document.addEventListener('click', function(e) {
            const bell = document.getElementById('bell-btn');
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