@extends('app')

@section('content')
<style>
    .trip-row { transition: background-color .15s ease, transform .15s ease; }
    .trip-row:hover { background-color: #f7f3ff !important; transform: translateX(2px); }
    .action-btn { transition: all .2s ease; }
    .action-btn:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,0,0,.14); }
    .stat-card { transition: transform .2s ease, box-shadow .2s ease; }
    .stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(0,0,0,.1) !important; }
    #search-input:focus { outline: none; box-shadow: 0 0 0 3px rgba(147, 51, 234, .2); }
</style>

<div class="min-h-screen bg-gradient-to-br from-slate-50 via-purple-50 to-slate-100 px-4 py-8 md:px-8">
    <div class="max-w-7xl mx-auto mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-purple-600 to-purple-700 flex items-center justify-center shadow-lg shadow-purple-200 flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 12.414m0 0L9.172 8.172m4.242 4.242L9.172 16.656M13.414 12.414L17.657 8.17M5 12a7 7 0 1114 0 7 7 0 01-14 0z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 leading-tight">Trip Management</h1>
                    <p class="text-gray-500 text-sm mt-0.5">Manage schedules, routes, and trip progress</p>
                </div>
            </div>
            <a href="{{ route('trips.create') }}"
               class="action-btn inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-purple-600 to-purple-700 text-white text-sm font-semibold rounded-xl shadow-md shadow-purple-200 hover:shadow-lg hover:shadow-purple-300 hover:-translate-y-0.5 self-start sm:self-auto">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">//www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Add New Trip
            </a>
        </div>
    </div>

    @php
        $total = count($trips);
        $completed = $trips->where('status', 'completed')->count();
        $inProgress = $trips->where('status', 'in_progress')->count();
        $pending = $trips->where('status', 'pending')->count();
    @endphp

    <div class="max-w-7xl mx-auto mb-6 grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="stat-card bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-purple-100 flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">//www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 01.553-.894L9 2m0 18l6-3m-6 3V2m6 15l6-3m-6 3V5m6 9V3m0 0l-6 3m6-3l-6 3m0 0L9 2" />
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ $total }}</p>
                <p class="text-xs text-gray-500 font-medium">Total Trips</p>
            </div>
        </div>
        <div class="stat-card bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">//www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ $completed }}</p>
                <p class="text-xs text-gray-500 font-medium">Completed</p>
            </div>
        </div>
        <div class="stat-card bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">//www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ $inProgress }}</p>
                <p class="text-xs text-gray-500 font-medium">In Progress</p>
            </div>
        </div>
        <div class="stat-card bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">//www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z" />
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ $pending }}</p>
                <p class="text-xs text-gray-500 font-medium">Pending</p>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center gap-3">
                <div class="flex items-center gap-2 flex-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <span class="text-sm font-semibold text-gray-700">All Trips</span>
                    <span class="ml-1 px-2 py-0.5 text-xs font-semibold bg-purple-100 text-purple-700 rounded-full">{{ $total }}</span>
                </div>
                <div class="relative sm:w-72">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/>
                    </svg>
                    <input id="search-input" type="text" placeholder="Search route, driver, or vehicle..."
                           class="w-full pl-9 pr-3 py-2 text-sm bg-gray-50 border border-gray-200 rounded-lg text-gray-700 placeholder-gray-400 focus:bg-white transition-all duration-200">
                </div>
            </div>

            @if($total > 0)
                <div class="overflow-x-auto">
                    <table class="w-full" id="trips-table">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Trip</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Route</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Driver</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Vehicle</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Schedule</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="text-right px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($trips as $trip)
                                <tr class="trip-row group"
                                    data-route="{{ strtolower(($trip->start_location ?? '') . ' ' . ($trip->end_location ?? '')) }}"
                                    data-driver="{{ strtolower($trip->driver->name ?? '') }}"
                                    data-vehicle="{{ strtolower($trip->vehicle->plate_number ?? '') }}">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-500 to-purple-700 flex items-center justify-center shadow-sm text-white text-sm font-bold">
                                                #{{ str_pad($trip->id, 2, '0', STR_PAD_LEFT) }}
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-gray-900">Trip #{{ str_pad($trip->id, 4, '0', STR_PAD_LEFT) }}</p>
                                                <p class="text-xs text-gray-400">{{ $trip->distance ? number_format($trip->distance, 1) . ' km' : 'Distance N/A' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900 font-medium">{{ $trip->start_location }}</div>
                                        <div class="text-xs text-gray-500">to {{ $trip->end_location }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ $trip->driver->name ?? 'Unassigned' }}</div>
                                        <div class="text-xs text-gray-500">{{ $trip->driver->license_number ?? 'No license' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-gray-900 text-white text-xs font-mono font-bold rounded-lg tracking-wider shadow-sm">
                                            {{ $trip->vehicle->plate_number ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900 font-medium">{{ $trip->start_time->format('M d, Y') }}</div>
                                        <div class="text-xs text-gray-500">{{ $trip->start_time->format('h:i A') }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($trip->status === 'completed')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-50 text-emerald-700 text-xs font-semibold rounded-full border border-emerald-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Completed
                                            </span>
                                        @elseif($trip->status === 'in_progress')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-blue-50 text-blue-700 text-xs font-semibold rounded-full border border-blue-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>In Progress
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-amber-50 text-amber-700 text-xs font-semibold rounded-full border border-amber-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>Pending
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <a href="{{ route('trips.show', $trip->id) }}" class="action-btn inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-blue-700 bg-blue-50 hover:bg-blue-100 border border-blue-200 rounded-lg">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
    </svg>
    View
</a>
                                            <a href="{{ route('trips.edit', $trip->id) }}" class="action-btn inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-amber-700 bg-amber-50 hover:bg-amber-100 border border-amber-200 rounded-lg">Edit</a>
                                            <button type="button"
                                                    data-delete-id="{{ $trip->id }}"
                                                    data-delete-name="Trip #{{ str_pad($trip->id, 4, '0', STR_PAD_LEFT) }}"
                                                    class="delete-btn action-btn inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 border border-red-200 rounded-lg">
                                                Delete
                                            </button>
                                            <form id="delete-form-{{ $trip->id }}" action="{{ route('trips.destroy', $trip->id) }}" method="POST" class="hidden">
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
                <div class="px-6 py-3 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
                    <p class="text-xs text-gray-400" id="row-count">Showing {{ $total }} trip(s)</p>
                    <p class="text-xs text-gray-400">Fleet Management System</p>
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-20 px-4 text-center">
                    <div class="w-20 h-20 bg-purple-50 rounded-full flex items-center justify-center mb-5">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 01.553-.894L9 2m0 18l6-3m-6 3V2m6 15l6-3m-6 3V5m6 9V3m0 0l-6 3m6-3l-6 3m0 0L9 2" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">No trips found</h3>
                    <p class="text-gray-400 text-sm mb-6 max-w-xs">No scheduled trips yet. Create your first trip to start managing routes.</p>
                    <a href="{{ route('trips.create') }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-purple-600 to-purple-700 text-white text-sm font-semibold rounded-xl shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
                        Add First Trip
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<div id="delete-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4"
     style="background:rgba(0,0,0,.45);backdrop-filter:blur(4px)">
    <div id="modal-box" class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 scale-95 opacity-0 transition-all duration-200">
        <div class="w-14 h-14 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
        </div>
        <h3 class="text-lg font-bold text-gray-900 text-center mb-1">Delete Trip?</h3>
        <p class="text-sm text-gray-500 text-center mb-6">
            Permanently delete <strong id="modal-trip-name" class="text-gray-800"></strong>? This cannot be undone.
        </p>
        <div class="flex gap-3">
            <button onclick="closeDeleteModal()" class="flex-1 px-4 py-2.5 text-sm font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">Cancel</button>
            <button id="confirm-delete-btn" class="flex-1 px-4 py-2.5 text-sm font-semibold text-white bg-red-500 hover:bg-red-600 rounded-xl transition-colors shadow-md shadow-red-200">Yes, Delete</button>
        </div>
    </div>
</div>

<script>
    const searchInput = document.getElementById('search-input');
    const tableRows   = document.querySelectorAll('#trips-table tbody tr');
    const rowCount    = document.getElementById('row-count');

    searchInput && searchInput.addEventListener('input', function() {
        const q = this.value.toLowerCase().trim();
        let visible = 0;
        tableRows.forEach(r => {
            const route = r.dataset.route || '';
            const driver = r.dataset.driver || '';
            const vehicle = r.dataset.vehicle || '';
            const match = route.includes(q) || driver.includes(q) || vehicle.includes(q);
            r.style.display = match ? '' : 'none';
            if (match) visible++;
        });
        if (rowCount) rowCount.textContent = q ? `Showing ${visible} of {{ $total }} trip(s)` : `Showing {{ $total }} trip(s)`;
    });

    let pendingId = null;
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            openDeleteModal(this.dataset.deleteId, this.dataset.deleteName);
        });
    });

    function openDeleteModal(id, name) {
        pendingId = id;
        document.getElementById('modal-trip-name').textContent = name;
        const m = document.getElementById('delete-modal');
        const b = document.getElementById('modal-box');
        m.classList.remove('hidden');
        m.classList.add('flex');
        setTimeout(() => { b.classList.remove('scale-95', 'opacity-0'); b.classList.add('scale-100', 'opacity-100'); }, 10);
    }

    function closeDeleteModal() {
        const m = document.getElementById('delete-modal');
        const b = document.getElementById('modal-box');
        b.classList.remove('scale-100', 'opacity-100');
        b.classList.add('scale-95', 'opacity-0');
        setTimeout(() => { m.classList.add('hidden'); m.classList.remove('flex'); pendingId = null; }, 200);
    }

    document.getElementById('confirm-delete-btn').addEventListener('click', () => {
        if (pendingId) document.getElementById('delete-form-' + pendingId).submit();
    });
    document.getElementById('delete-modal').addEventListener('click', function(e) {
        if (e.target === this) closeDeleteModal();
    });
</script>
@endsection