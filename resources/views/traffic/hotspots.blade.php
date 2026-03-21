@extends('app')

@section('content')

{{-- Leaflet CSS --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<div class="min-h-screen bg-gradient-to-br from-slate-50 via-amber-50 to-slate-100 py-8">
    <div class="max-w-7xl mx-auto px-4 md:px-8">

        {{-- Header --}}
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-12 h-12 bg-gradient-to-br from-amber-500 to-amber-600 rounded-lg flex items-center justify-center text-white text-xl">🚨</div>
                        <h1 class="text-4xl font-bold text-gray-900">Congestion Hotspots</h1>
                    </div>
                    <p class="text-gray-600 ml-16">Click on any hotspot marker or table row to view detailed traffic data</p>
                </div>
                <div class="flex items-center gap-2">
                    <button id="toggle-map-btn" onclick="toggleMap()"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-600 text-sm font-medium rounded-xl shadow-sm hover:bg-gray-50 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z" />
                        </svg>
                        <span id="toggle-map-label">Hide Map</span>
                    </button>
                </div>
            </div>
        </div>

        {{-- Map --}}
        <div id="map-container" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6 transition-all duration-300">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-amber-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z" />
                    </svg>
                    <span class="text-sm font-semibold text-gray-700">Live Hotspot Map</span>
                    <span class="ml-1 px-2 py-0.5 text-xs font-semibold bg-amber-100 text-amber-700 rounded-full">{{ count($hotspots) }} hotspot(s)</span>
                </div>
                {{-- Legend --}}
                <div class="flex items-center gap-4 text-xs text-gray-500">
                    <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-green-500 inline-block"></span> Low</span>
                    <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-yellow-400 inline-block"></span> Moderate</span>
                    <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-orange-500 inline-block"></span> High</span>
                    <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-red-500 inline-block"></span> Severe</span>
                </div>
            </div>
            <div id="hotspot-map" style="height: 420px; width: 100%;"></div>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <h2 class="text-lg font-semibold text-gray-900">
                    Detected Hotspots ({{ count($hotspots) }})
                </h2>
                <p class="text-sm text-gray-600 mt-1">Last 2 hours • Sorted by incident count</p>
            </div>

            @if(count($hotspots) > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Location</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Incidents</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Avg Speed</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Level</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($hotspots as $index => $hotspot)
                                <tr class="border-b border-gray-100 hover:bg-red-50 transition-colors cursor-pointer hotspot-row"
                                    data-lat="{{ $hotspot->latitude }}"
                                    data-lng="{{ $hotspot->longitude }}"
                                    data-index="{{ $index }}">
                                    <td class="px-6 py-4 text-sm text-gray-900 font-medium">
                                        <div class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-amber-500 flex-shrink-0">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                            </svg>
                                            <a href="https://www.google.com/maps?q={{ $hotspot->latitude }},{{ $hotspot->longitude }}"
                                               target="_blank"
                                               class="text-amber-600 hover:underline font-mono"
                                               onclick="event.stopPropagation()">
                                                {{ number_format($hotspot->latitude, 6) }}, {{ number_format($hotspot->longitude, 6) }}
                                            </a>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 font-medium">
                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-red-100 text-red-800 font-bold">
                                            {{ $hotspot->incident_count }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ number_format($hotspot->avg_speed, 1) }} km/h
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <span class="px-3 py-1 rounded-full text-xs font-medium
                                            @if($hotspot->congestion_level === 'severe') bg-red-100 text-red-800
                                            @elseif($hotspot->congestion_level === 'high') bg-orange-100 text-orange-800
                                            @elseif($hotspot->congestion_level === 'moderate') bg-yellow-100 text-yellow-800
                                            @else bg-green-100 text-green-800
                                            @endif">
                                            {{ ucfirst($hotspot->congestion_level) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <button class="text-blue-600 hover:text-blue-800 font-medium bg-blue-50 hover:bg-blue-100 px-3 py-1 rounded transition-colors view-json-btn">
                                            View Details
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="px-6 py-12 text-center text-gray-500">
                    <div class="text-5xl mb-4">✨</div>
                    <p class="text-lg">No congestion hotspots detected</p>
                    <p class="text-sm mt-1">No areas with multiple congestion incidents in the last 2 hours</p>
                </div>
            @endif
        </div>

        <div class="mt-8">
            <a href="{{ route('traffic.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-600 text-sm font-medium rounded-xl shadow-sm hover:bg-gray-50">
                ← Back to Dashboard
            </a>
        </div>
    </div>

    {{-- JSON Detail Modal --}}
    <div id="jsonModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl max-h-[90vh] overflow-auto w-full">
            <div class="sticky top-0 bg-gray-50 border-b border-gray-200 px-6 py-4 flex items-center justify-between rounded-t-2xl">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Hotspot Details</h3>
                    <p id="hotspotLocation" class="text-sm text-gray-600 mt-0.5 font-mono"></p>
                </div>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-700 text-2xl leading-none">&times;</button>
            </div>

            <div class="p-6">
                <div id="loadingMsg" class="text-center py-8">
                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-amber-500"></div>
                    <p class="text-gray-600 mt-2">Loading hotspot data...</p>
                </div>

                <div id="jsonContent" class="hidden">
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="bg-amber-50 rounded-xl p-4 border border-amber-100">
                            <p class="text-xs text-gray-500 mb-1">Incident Count</p>
                            <p id="incidentCount" class="text-2xl font-bold text-amber-600">-</p>
                        </div>
                        <div class="bg-orange-50 rounded-xl p-4 border border-orange-100">
                            <p class="text-xs text-gray-500 mb-1">Average Speed</p>
                            <p id="avgSpeed" class="text-2xl font-bold text-orange-600">-</p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h4 class="text-sm font-semibold text-gray-900 mb-3">Recent Traffic Records</h4>
                        <div id="recordsList" class="space-y-2 max-h-64 overflow-y-auto"></div>
                    </div>

                    <div>
                        <h4 class="text-sm font-semibold text-gray-900 mb-2">Raw JSON</h4>
                        <pre id="jsonText" class="bg-gray-50 border border-gray-200 p-4 rounded-xl text-xs overflow-x-auto max-h-48 text-gray-700"></pre>
                    </div>

                    <div class="mt-5 flex gap-2">
                        <button onclick="copyJsonToClipboard()"
                            class="flex-1 bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            Copy JSON
                        </button>
                        <button onclick="closeModal()"
                            class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Leaflet JS --}}
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

@php
    $hotspotsJson = $hotspots->map(function($h) {
        return [
            'lat'              => (float) $h->latitude,
            'lng'              => (float) $h->longitude,
            'incident_count'   => $h->incident_count,
            'avg_speed'        => round($h->avg_speed, 1),
            'congestion_level' => $h->congestion_level,
        ];
    });
@endphp

<script>
    // ── Hotspot data from Laravel ─────────────────────────────────────────────
    const hotspotsData = @json($hotspotsJson);

    // ── Map setup ─────────────────────────────────────────────────────────────
    const markerColors = {
        low:      '#10b981',
        moderate: '#fbbf24',
        high:     '#f97316',
        severe:   '#ef4444',
    };

    function makeIcon(level) {
        const color = markerColors[level] || '#f97316';
        const svg = `
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36 48" width="36" height="48">
                <path d="M18 0C8.06 0 0 8.06 0 18c0 13.5 18 30 18 30s18-16.5 18-30C36 8.06 27.94 0 18 0z"
                      fill="${color}" stroke="white" stroke-width="2"/>
                <circle cx="18" cy="18" r="8" fill="white" opacity="0.9"/>
            </svg>`;
        return L.divIcon({
            html: svg,
            className: '',
            iconSize: [36, 48],
            iconAnchor: [18, 48],
            popupAnchor: [0, -48],
        });
    }

    let map, markers = [];
    let mapVisible = true;

    function initMap() {
        if (hotspotsData.length === 0) {
            // Default center (Philippines) if no data
            map = L.map('hotspot-map').setView([12.8797, 121.7740], 6);
        } else {
            const avgLat = hotspotsData.reduce((s, h) => s + h.lat, 0) / hotspotsData.length;
            const avgLng = hotspotsData.reduce((s, h) => s + h.lng, 0) / hotspotsData.length;
            map = L.map('hotspot-map').setView([avgLat, avgLng], hotspotsData.length === 1 ? 14 : 12);
        }

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
            maxZoom: 19,
        }).addTo(map);

        hotspotsData.forEach((h, i) => {
            const marker = L.marker([h.lat, h.lng], { icon: makeIcon(h.congestion_level) })
                .addTo(map)
                .bindPopup(`
                    <div style="min-width:180px; font-family: sans-serif;">
                        <div style="font-weight:700; font-size:13px; margin-bottom:6px;">
                            ${h.congestion_level.charAt(0).toUpperCase() + h.congestion_level.slice(1)} Congestion
                        </div>
                        <div style="font-size:12px; color:#555; margin-bottom:4px;">
                            📍 ${h.lat.toFixed(4)}, ${h.lng.toFixed(4)}
                        </div>
                        <div style="font-size:12px; color:#555; margin-bottom:4px;">
                            🚨 <strong>${h.incident_count}</strong> incidents
                        </div>
                        <div style="font-size:12px; color:#555; margin-bottom:8px;">
                            🚗 Avg speed: <strong>${h.avg_speed} km/h</strong>
                        </div>
                        <button onclick="viewHotspotData(${h.lat}, ${h.lng})"
                            style="width:100%; padding:5px; background:#f59e0b; color:white; border:none;
                                   border-radius:6px; font-size:12px; cursor:pointer; font-weight:600;">
                            View Details
                        </button>
                    </div>
                `);

            // Pulse circle for severe/high
            if (h.congestion_level === 'severe' || h.congestion_level === 'high') {
                L.circle([h.lat, h.lng], {
                    color: markerColors[h.congestion_level],
                    fillColor: markerColors[h.congestion_level],
                    fillOpacity: 0.15,
                    radius: 300,
                    weight: 1,
                }).addTo(map);
            }

            markers.push(marker);
        });

        // Fit bounds if multiple hotspots
        if (hotspotsData.length > 1) {
            const group = L.featureGroup(markers);
            map.fitBounds(group.getBounds().pad(0.3));
        }
    }

    // ── Toggle map visibility ─────────────────────────────────────────────────
    function toggleMap() {
        const container = document.getElementById('map-container');
        const label = document.getElementById('toggle-map-label');
        mapVisible = !mapVisible;
        container.style.display = mapVisible ? '' : 'none';
        label.textContent = mapVisible ? 'Hide Map' : 'Show Map';
        if (mapVisible && map) map.invalidateSize();
    }

    // ── Fly to marker when table row is clicked ───────────────────────────────
    document.addEventListener('DOMContentLoaded', function () {
        initMap();

        document.querySelectorAll('.hotspot-row').forEach((row, i) => {
            row.addEventListener('click', function () {
                const lat = parseFloat(this.dataset.lat);
                const lng = parseFloat(this.dataset.lng);

                // Scroll to map and fly to marker
                if (mapVisible) {
                    document.getElementById('map-container').scrollIntoView({ behavior: 'smooth', block: 'center' });
                    setTimeout(() => {
                        map.flyTo([lat, lng], 15, { duration: 1 });
                        if (markers[i]) markers[i].openPopup();
                    }, 400);
                }
            });
        });

        document.querySelectorAll('.view-json-btn').forEach((btn, i) => {
            btn.addEventListener('click', function (e) {
                e.stopPropagation();
                const row = this.closest('.hotspot-row');
                viewHotspotData(parseFloat(row.dataset.lat), parseFloat(row.dataset.lng));
            });
        });
    });

    // ── Modal logic ───────────────────────────────────────────────────────────
    let currentJsonData = null;

    function viewHotspotData(latitude, longitude) {
        document.getElementById('jsonModal').classList.remove('hidden');
        document.getElementById('loadingMsg').classList.remove('hidden');
        document.getElementById('jsonContent').classList.add('hidden');
        document.getElementById('hotspotLocation').textContent =
            `${latitude.toFixed(6)}, ${longitude.toFixed(6)}`;

        const baseUrl = '{{ route("traffic.hotspot-data", ["latitude" => "LAT", "longitude" => "LNG"]) }}';
        const url = baseUrl.replace('LAT', latitude).replace('LNG', longitude);

        fetch(url)
            .then(r => r.json())
            .then(data => { currentJsonData = data; displayHotspotData(data); })
            .catch(() => {
                document.getElementById('loadingMsg').innerHTML =
                    '<p class="text-red-600">Error loading data. Please try again.</p>';
            });
    }

    function displayHotspotData(data) {
        if (!data.success) {
            document.getElementById('loadingMsg').innerHTML =
                `<p class="text-red-600">${data.message || 'No data available'}</p>`;
            return;
        }
        const d = data.data;
        document.getElementById('incidentCount').textContent = d.summary.incident_count;
        document.getElementById('avgSpeed').textContent = d.summary.avg_speed.toFixed(1) + ' km/h';

        const list = document.getElementById('recordsList');
        if (d.records?.length > 0) {
            list.innerHTML = d.records.slice(0, 5).map(r => `
                <div class="bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-900">${r.speed.toFixed(1)} km/h</p>
                        <p class="text-xs text-gray-500 mt-0.5">${r.congestion_level.toUpperCase()}</p>
                    </div>
                    <span class="text-xs text-gray-400">${new Date(r.timestamp).toLocaleString()}</span>
                </div>`).join('');
            if (d.records.length > 5) {
                list.innerHTML += `<p class="text-center text-xs text-gray-400 pt-2">… and ${d.records.length - 5} more records</p>`;
            }
        } else {
            list.innerHTML = '<p class="text-gray-500 text-sm">No records found</p>';
        }

        document.getElementById('jsonText').textContent = JSON.stringify(data, null, 2);
        document.getElementById('loadingMsg').classList.add('hidden');
        document.getElementById('jsonContent').classList.remove('hidden');
    }

    function copyJsonToClipboard() {
        if (!currentJsonData) return;
        navigator.clipboard.writeText(JSON.stringify(currentJsonData, null, 2))
            .then(() => alert('JSON copied to clipboard!'))
            .catch(() => alert('Failed to copy to clipboard'));
    }

    function closeModal() {
        document.getElementById('jsonModal').classList.add('hidden');
        currentJsonData = null;
    }

    document.getElementById('jsonModal').addEventListener('click', e => {
        if (e.target === document.getElementById('jsonModal')) closeModal();
    });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });
</script>

<style>
    #jsonModal:not(.hidden) { animation: fadeIn .2s ease-in; }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    .leaflet-popup-content-wrapper { border-radius: 12px !important; }
    .leaflet-popup-content { margin: 12px 14px !important; }
</style>

@endsection