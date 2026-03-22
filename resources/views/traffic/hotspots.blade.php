@extends('app')

@section('content')

{{-- Leaflet CSS --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap');
    #suggest-modal * { font-family: 'DM Sans', sans-serif; }

    .sr-modal-bg {
        position: fixed; inset: 0; z-index: 9999;
        display: none; align-items: center; justify-content: center;
        padding: 1rem; background: rgba(0,0,0,.5); backdrop-filter: blur(4px);
    }
    .sr-modal-bg.open { display: flex; }
    .sr-modal-box {
        background: #fff; border-radius: 20px;
        width: 100%; max-width: 560px;
        transform: scale(.95); opacity: 0; transition: all .22s;
        box-shadow: 0 24px 64px rgba(0,0,0,.22); overflow: hidden;
        max-height: 90vh; overflow-y: auto;
    }
    .sr-modal-box.open { transform: scale(1); opacity: 1; }
    .sr-header {
        background: linear-gradient(135deg, #d97706, #b45309);
        padding: 1.5rem; position: relative; overflow: hidden;
    }
    .sr-header::before {
        content: ''; position: absolute; top: -40px; right: -40px;
        width: 160px; height: 160px; border-radius: 50%; background: rgba(255,255,255,.08);
    }
    .sr-header-top { display: flex; align-items: flex-start; justify-content: space-between; position: relative; }
    .sr-header-icon {
        width: 44px; height: 44px; border-radius: 12px;
        background: rgba(255,255,255,.2); border: 1px solid rgba(255,255,255,.3);
        display: flex; align-items: center; justify-content: center; font-size: 1.25rem;
    }
    .sr-header-title { font-size: 1.1rem; font-weight: 700; color: #fff; margin-top: .75rem; letter-spacing: -.01em; }
    .sr-header-sub { font-size: .8rem; color: rgba(255,255,255,.7); margin-top: .2rem; font-family: 'DM Mono', monospace; }
    .sr-close-btn {
        width: 32px; height: 32px; border-radius: 8px;
        background: rgba(255,255,255,.15); border: none; cursor: pointer;
        color: #fff; font-size: 1.1rem; display: flex; align-items: center; justify-content: center;
        transition: background .15s;
    }
    .sr-close-btn:hover { background: rgba(255,255,255,.25); }
    .sr-congestion-badge {
        display: inline-flex; align-items: center; gap: .4rem;
        font-size: .72rem; font-weight: 700; padding: .25rem .7rem; border-radius: 99px;
        border: 1px solid rgba(255,255,255,.3); background: rgba(255,255,255,.15); color: #fff;
        margin-top: .6rem; letter-spacing: .03em; text-transform: uppercase;
    }
    .sr-congestion-dot { width: 6px; height: 6px; border-radius: 50%; background: #fff; animation: pulse-dot 2s ease-in-out infinite; }
    @keyframes pulse-dot { 0%,100%{opacity:1} 50%{opacity:.4} }
    .sr-body { padding: 1.5rem; }
    .sr-thinking {
        display: flex; flex-direction: column; align-items: center;
        justify-content: center; padding: 2.5rem 1rem; gap: 1rem;
    }
    .sr-thinking-dots { display: flex; gap: .4rem; }
    .sr-thinking-dots span {
        width: 8px; height: 8px; border-radius: 50%; background: #d97706;
        animation: bounce-dot .8s ease-in-out infinite;
    }
    .sr-thinking-dots span:nth-child(2) { animation-delay: .15s; }
    .sr-thinking-dots span:nth-child(3) { animation-delay: .3s; }
    @keyframes bounce-dot { 0%,80%,100%{transform:scale(0.7);opacity:.5} 40%{transform:scale(1.1);opacity:1} }
    .sr-thinking-label { font-size: .85rem; color: #9e9b95; font-weight: 500; }
    .sr-result { display: none; }
    .sr-result.visible { display: block; animation: fadeUp .3s ease; }
    @keyframes fadeUp { from{opacity:0;transform:translateY(8px)} to{opacity:1;transform:translateY(0)} }
    .sr-section { margin-bottom: 1.25rem; }
    .sr-section-label {
        font-size: .68rem; font-weight: 700; letter-spacing: .08em;
        text-transform: uppercase; color: #b0ada7; margin-bottom: .6rem;
        display: flex; align-items: center; gap: .4rem;
    }
    .sr-section-label svg { width: 12px; height: 12px; }
    .sr-route-box { background: #fffbeb; border: 1px solid #fde68a; border-radius: 12px; padding: 1rem 1.1rem; }
    .sr-route-text { font-size: .9rem; font-weight: 600; color: #111; line-height: 1.5; }
    .sr-reason-box { background: #f7f6f3; border: 1px solid #e8e6e1; border-radius: 12px; padding: 1rem 1.1rem; }
    .sr-reason-text { font-size: .8375rem; color: #555; line-height: 1.6; }
    .sr-stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: .625rem; margin-bottom: 1.25rem; }
    .sr-stat-box { border-radius: 10px; padding: .75rem; text-align: center; border: 1px solid transparent; }
    .sr-stat-val { font-size: 1rem; font-weight: 700; color: #111; letter-spacing: -.02em; }
    .sr-stat-lbl { font-size: .68rem; color: #9e9b95; font-weight: 500; margin-top: .15rem; }
    .sr-hotspot-item {
        display: flex; align-items: flex-start; gap: .6rem;
        padding: .6rem .8rem; background: #fff5f5; border: 1px solid #fecaca;
        border-radius: 9px; margin-bottom: .4rem; font-size: .8rem; color: #991b1b; line-height: 1.4;
    }
    .sr-hotspot-item svg { width: 14px; height: 14px; flex-shrink: 0; margin-top: .1rem; color: #dc2626; }
    .sr-ai-badge {
        display: inline-flex; align-items: center; gap: .35rem;
        background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d;
        font-size: .68rem; font-weight: 600; padding: .2rem .55rem;
        border-radius: 99px; letter-spacing: .03em; margin-bottom: 1rem;
    }
    .sr-ai-badge svg { width: 10px; height: 10px; }
    .sr-map-box {
        border-radius: 12px; overflow: hidden;
        border: 1px solid #e8e6e1; margin-bottom: 1.25rem; position: relative;
    }
    .sr-map-legend {
        position: absolute; top: 8px; left: 8px; z-index: 500;
        background: rgba(255,255,255,.93); border: 1px solid #e8e6e1;
        border-radius: 8px; padding: .3rem .7rem;
        font-size: .68rem; font-weight: 600; color: #333;
        display: flex; align-items: center; gap: .5rem;
        backdrop-filter: blur(4px); box-shadow: 0 1px 4px rgba(0,0,0,.08);
    }
    .sr-leg-dot { width: 9px; height: 9px; border-radius: 50%; display: inline-block; }
    .sr-actions { display: flex; gap: .625rem; margin-top: 1.25rem; }
    .sr-btn { flex: 1; padding: .65rem; border-radius: 10px; font-size: .875rem; font-weight: 600; cursor: pointer; border: none; transition: all .15s; font-family: 'DM Sans', sans-serif; }
    .sr-btn-primary { background: #d97706; color: #fff; box-shadow: 0 4px 12px rgba(217,119,6,.3); }
    .sr-btn-primary:hover { background: #b45309; }
    .sr-btn-secondary { background: #f5f4f1; color: #444; }
    .sr-btn-secondary:hover { background: #eae8e3; }
    #jsonModal:not(.hidden) { animation: fadeIn .2s ease-in; }
    @keyframes fadeIn { from{opacity:0} to{opacity:1} }
    .leaflet-popup-content-wrapper { border-radius: 12px !important; }
    .leaflet-popup-content { margin: 12px 14px !important; }
</style>

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
                    <button onclick="toggleMap()"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-600 text-sm font-medium rounded-xl shadow-sm hover:bg-gray-50 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c-.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z" />
                        </svg>
                        <span id="toggle-map-label">Hide Map</span>
                    </button>
                </div>
            </div>
        </div>

        {{-- Main Map --}}
        <div id="map-container" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-amber-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c-.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z" />
                    </svg>
                    <span class="text-sm font-semibold text-gray-700">Live Hotspot Map</span>
                    <span class="ml-1 px-2 py-0.5 text-xs font-semibold bg-amber-100 text-amber-700 rounded-full">{{ count($hotspots) }} hotspot(s)</span>
                </div>
                <div class="flex items-center gap-4 text-xs text-gray-500">
                    <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-green-500 inline-block"></span> Low</span>
                    <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-yellow-400 inline-block"></span> Moderate</span>
                    <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-orange-500 inline-block"></span> High</span>
                    <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-red-500 inline-block"></span> Severe</span>
                </div>
            </div>
            <div id="hotspot-map" style="height:420px;width:100%;"></div>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <h2 class="text-lg font-semibold text-gray-900">Detected Hotspots ({{ count($hotspots) }})</h2>
                <p class="text-sm text-gray-600 mt-1">Last 2 hours • Sorted by incident count</p>
            </div>
            @if(count($hotspots) > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Location</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Incidents</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Avg Speed</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Level</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($hotspots as $index => $hotspot)
                        <tr class="border-b border-gray-100 hover:bg-amber-50 transition-colors cursor-pointer hotspot-row"
                            data-lat="{{ $hotspot->latitude }}" data-lng="{{ $hotspot->longitude }}"
                            data-level="{{ $hotspot->congestion_level }}" data-speed="{{ number_format($hotspot->avg_speed,1) }}"
                            data-incidents="{{ $hotspot->incident_count }}" data-index="{{ $index }}">
                            <td class="px-6 py-4 text-sm">
                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-amber-500 flex-shrink-0">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                                    </svg>
                                    <a href="https://www.google.com/maps?q={{ $hotspot->latitude }},{{ $hotspot->longitude }}"
                                       target="_blank" onclick="event.stopPropagation()"
                                       class="text-amber-600 hover:underline font-mono text-xs">
                                        {{ number_format($hotspot->latitude,6) }}, {{ number_format($hotspot->longitude,6) }}
                                    </a>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-red-100 text-red-800 text-xs font-bold">{{ $hotspot->incident_count }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-700">
                                {{ number_format($hotspot->avg_speed,1) }} <span class="text-gray-400 font-normal text-xs">km/h</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    @if($hotspot->congestion_level==='severe') bg-red-100 text-red-800
                                    @elseif($hotspot->congestion_level==='high') bg-orange-100 text-orange-800
                                    @elseif($hotspot->congestion_level==='moderate') bg-yellow-100 text-yellow-800
                                    @else bg-green-100 text-green-800 @endif">
                                    {{ ucfirst($hotspot->congestion_level) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <button onclick="event.stopPropagation(); viewHotspotData({{ $hotspot->latitude }},{{ $hotspot->longitude }})"
                                        class="text-blue-600 font-semibold bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg text-xs border border-blue-200 transition-colors">
                                        View Details
                                    </button>
                                    <button onclick="event.stopPropagation(); openSuggestModal({{ $hotspot->latitude }},{{ $hotspot->longitude }},'{{ $hotspot->congestion_level }}',{{ number_format($hotspot->avg_speed,1) }},{{ $hotspot->incident_count }})"
                                        class="inline-flex items-center gap-1 text-amber-700 font-semibold bg-amber-50 hover:bg-amber-100 px-3 py-1.5 rounded-lg text-xs border border-amber-200 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="w-3 h-3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 01.553-.894L9 2m0 18l6-3m-6 3V2m6 15l6-3m-6 3V5m6 9V3m0 0l-6 3m6-3l-6 3"/>
                                        </svg>
                                        Suggest Route
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="px-6 py-12 text-center text-gray-500">
                <div class="text-5xl mb-4">✨</div>
                <p class="text-lg font-semibold">No congestion hotspots detected</p>
                <p class="text-sm mt-1 text-gray-400">No areas with multiple congestion incidents in the last 2 hours</p>
            </div>
            @endif
        </div>

        <div class="mt-8">
            <a href="{{ route('traffic.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-600 text-sm font-medium rounded-xl shadow-sm hover:bg-gray-50">
                ← Back to Dashboard
            </a>
        </div>
    </div>

    {{-- Route Suggestion Modal --}}
    <div id="suggest-modal" class="sr-modal-bg" onclick="if(event.target===this)closeSuggestModal()">
        <div id="suggest-modal-box" class="sr-modal-box">
            <div class="sr-header">
                <div class="sr-header-top">
                    <div class="sr-header-icon">🧭</div>
                    <button onclick="closeSuggestModal()" class="sr-close-btn">✕</button>
                </div>
                <div class="sr-header-title">Alternative Route Suggestion</div>
                <div class="sr-header-sub" id="sr-coords">—</div>
                <div class="sr-congestion-badge"><span class="sr-congestion-dot"></span><span id="sr-level-text">—</span></div>
            </div>
            <div class="sr-body">
                <div class="sr-thinking" id="sr-thinking">
                    <div class="sr-thinking-dots"><span></span><span></span><span></span></div>
                    <div class="sr-thinking-label">Analyzing traffic conditions…</div>
                </div>
                <div class="sr-result" id="sr-result">
                    <div class="sr-ai-badge">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/></svg>
                        AI-Simulated Suggestion
                    </div>
                    <div class="sr-stats">
                        <div class="sr-stat-box" style="background:#f0fdf4;border-color:#bbf7d0">
                            <div class="sr-stat-val" id="sr-time-saved">—</div>
                            <div class="sr-stat-lbl">Time Saved</div>
                        </div>
                        <div class="sr-stat-box" style="background:#eff6ff;border-color:#bfdbfe">
                            <div class="sr-stat-val" id="sr-confidence">—</div>
                            <div class="sr-stat-lbl">Confidence</div>
                        </div>
                        <div class="sr-stat-box" style="background:#fff5f5;border-color:#fecaca">
                            <div class="sr-stat-val" id="sr-avoided">—</div>
                            <div class="sr-stat-lbl">Hotspots Avoided</div>
                        </div>
                    </div>
                    <div class="sr-section">
                        <div class="sr-section-label">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c-.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z"/></svg>
                            Route Map
                        </div>
                        <div class="sr-map-box">
                            <div class="sr-map-legend">
                                <span class="sr-leg-dot" style="background:#22c55e"></span> Alt Route &nbsp;
                                <span class="sr-leg-dot" style="background:#ef4444"></span> Congestion
                            </div>
                            <div id="sr-mini-map" style="height:220px;width:100%;"></div>
                        </div>
                    </div>
                    <div class="sr-section">
                        <div class="sr-section-label">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 01.553-.894L9 2m0 18l6-3m-6 3V2m6 15l6-3m-6 3V5"/></svg>
                            Suggested Alternative Route
                        </div>
                        <div class="sr-route-box"><div class="sr-route-text" id="sr-route-text">—</div></div>
                    </div>
                    <div class="sr-section">
                        <div class="sr-section-label">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/></svg>
                            Why This Route
                        </div>
                        <div class="sr-reason-box"><div class="sr-reason-text" id="sr-reason-text">—</div></div>
                    </div>
                    <div class="sr-section">
                        <div class="sr-section-label">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                            Congestion Points Avoided
                        </div>
                        <div id="sr-hotspots-list"></div>
                    </div>
                    <div class="sr-actions">
                        <button onclick="closeSuggestModal()" class="sr-btn sr-btn-secondary">Close</button>
                        <button onclick="openInMaps()" class="sr-btn sr-btn-primary">Open in Google Maps</button>
                    </div>
                </div>
            </div>
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
                        <button onclick="copyJsonToClipboard()" class="flex-1 bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-lg text-sm font-medium">Copy JSON</button>
                        <button onclick="closeModal()" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

@php
    $hotspotsJson = $hotspots->map(fn($h) => [
        'lat'              => (float) $h->latitude,
        'lng'              => (float) $h->longitude,
        'incident_count'   => $h->incident_count,
        'avg_speed'        => round($h->avg_speed, 1),
        'congestion_level' => $h->congestion_level,
    ]);
@endphp

<script>
const hotspotsData = @json($hotspotsJson);

// ── Route suggestion text pool ────────────────────────────────────────────
const ROUTE_ALTERNATIVES = {
    severe: [
        { route: 'Take the C-5 Road via Libis flyover, then connect to EDSA Southbound avoiding the congestion core. Estimated detour adds 4.2 km but bypasses the incident zone.', reason: 'The primary route is experiencing severe gridlock with near-zero movement. The C-5 alternative maintains average speeds of 45–60 km/h and has been validated by recent fleet GPS data showing 73% faster transit times.', timeSaved: '~22 mins', confidence: '87%', hotspots: ['EDSA–Ortigas intersection (8.3 km/h avg)', 'Shaw Boulevard merge point (4.1 km/h avg)', 'Primary incident cluster (0–5 km/h)'] },
        { route: 'Reroute via the circumferential road using the R-10 bypass. Exit at the industrial zone junction and reconnect to the main corridor 3.8 km ahead of the congestion point.', reason: 'Heavy congestion detected across a 2.4 km stretch. The R-10 bypass consistently shows lower traffic density during peak hours based on historical data from similar incidents.', timeSaved: '~18 mins', confidence: '81%', hotspots: ['Primary route bottleneck (6.7 km/h avg)', 'Merge ramp backup (11.2 km/h avg)'] },
    ],
    high: [
        { route: 'Use the parallel service road running 1.5 km east of the primary route. Rejoin the main road past the highway junction where congestion clears.', reason: 'High congestion is localized to a 1.8 km segment near the intersection. The service road typically carries 40% less traffic volume and allows speeds of 35–50 km/h through the affected zone.', timeSaved: '~14 mins', confidence: '79%', hotspots: ['Intersection queue (18.4 km/h avg)', 'Secondary bottleneck ahead (22.1 km/h avg)'] },
        { route: 'Divert via the expressway spur, taking Exit 7 toward the bypass connector. This adds 6 km to the route but eliminates the high-congestion segment entirely.', reason: 'Traffic analysis shows the current high congestion is caused by signal timing issues and a lane closure. The expressway spur bypasses this entirely with average speeds above 80 km/h.', timeSaved: '~11 mins', confidence: '84%', hotspots: ['Lane closure impact zone (19.8 km/h avg)'] },
    ],
    moderate: [
        { route: 'Slight reroute recommended: take the inner road 800 meters before the congestion onset point. This parallel corridor adds minimal distance and avoids the moderate slowdown.', reason: 'Moderate congestion is typical for this time period and location. The inner road alternative reduces exposure to the slowdown by 65% while adding only 1.2 km to the total journey.', timeSaved: '~8 mins', confidence: '72%', hotspots: ['Moderate slowdown zone (38.7 km/h avg)', 'Minor merge delay (42.3 km/h avg)'] },
        { route: 'Continue on primary route but switch to the right lane 1 km before the slowdown and use the truck bypass lane near the industrial gate to skip the main bottleneck.', reason: 'The congestion is moderate and concentrated at a single merge point. Using the truck bypass lane is permitted during off-peak hours and typically saves 6–10 minutes on similar routes.', timeSaved: '~6 mins', confidence: '68%', hotspots: ['Merge point slowdown (41.2 km/h avg)'] },
    ],
};

const NEAR_CITIES = {
    '10.3157_123.8854': { from: 'Cebu City',     to: 'Mandaue City',  alt: 'Cebu South Road → Reclamation Area → North Road (Bypass)' },
    '14.5995_120.9842': { from: 'Manila',         to: 'Quezon City',   alt: 'Circumferential Road C-4 → España Extension → EDSA North' },
    '7.0644_125.6078':  { from: 'Davao City',     to: 'Sta. Ana',      alt: 'Diversion Road via Buhangin → Panacan Coastal Road' },
    '6.9214_122.079':   { from: 'Zamboanga City', to: 'Pasonanca',     alt: 'Veterans Avenue → Tomas Claudio Street → Pilar Road' },
    '8.4542_124.6319':  { from: 'Cagayan de Oro', to: 'Iligan City',   alt: 'N1 Highway inner lane → Gusa Bypass → National Highway' },
    '10.2769_123.6381': { from: 'Cebu City',      to: 'Toledo City',   alt: 'Transcentral Highway (Mountain Route) via Busay Ridge' },
};

// ── OSRM routing destinations ─────────────────────────────────────────────
const ROUTE_DESTINATIONS = {
    '10.3157_123.8854': { toLat: 10.3236, toLng: 123.9223 },
    '14.5995_120.9842': { toLat: 14.6760, toLng: 121.0437 },
    '7.0644_125.6078':  { toLat: 7.1907,  toLng: 125.4553 },
    '6.9214_122.079':   { toLat: 7.0747,  toLng: 122.0672 },
    '8.4542_124.6319':  { toLat: 8.2280,  toLng: 124.2452 },
    '10.2769_123.6381': { toLat: 10.3157, toLng: 123.8854 },
};

let currentHotspotLat, currentHotspotLng;
let miniMap = null, miniMapLayers = [];

// ── Decode OSRM polyline ──────────────────────────────────────────────────
function decodePolyline(encoded) {
    const pts = [];
    let index = 0, lat = 0, lng = 0;
    while (index < encoded.length) {
        let b, shift = 0, result = 0;
        do { b = encoded.charCodeAt(index++) - 63; result |= (b & 0x1f) << shift; shift += 5; } while (b >= 0x20);
        lat += (result & 1) ? ~(result >> 1) : result >> 1;
        shift = 0; result = 0;
        do { b = encoded.charCodeAt(index++) - 63; result |= (b & 0x1f) << shift; shift += 5; } while (b >= 0x20);
        lng += (result & 1) ? ~(result >> 1) : result >> 1;
        pts.push([lat / 1e5, lng / 1e5]);
    }
    return pts;
}

// ── OSRM fetch helpers ────────────────────────────────────────────────────
async function fetchOsrmRoute(fromLat, fromLng, toLat, toLng) {
    const url = `https://router.project-osrm.org/route/v1/driving/${fromLng},${fromLat};${toLng},${toLat}?overview=full&geometries=polyline`;
    const res = await fetch(url);
    if (!res.ok) throw new Error('OSRM failed');
    const data = await res.json();
    if (data.code !== 'Ok' || !data.routes?.length) throw new Error('No route');
    return decodePolyline(data.routes[0].geometry);
}

async function fetchDetourRoute(hotLat, hotLng, toLat, toLng) {
    const off = 0.015;
    const side = Math.random() > 0.5 ? 1 : -1;
    const bypassLat = hotLat + side * off;
    const bypassLng = hotLng + off * 0.5;
    const fromLat = hotLat - off * 1.5;
    const fromLng = hotLng - off * 1.5;
    const url = `https://router.project-osrm.org/route/v1/driving/${fromLng},${fromLat};${bypassLng},${bypassLat};${toLng},${toLat}?overview=full&geometries=polyline`;
    const res = await fetch(url);
    if (!res.ok) throw new Error('OSRM detour failed');
    const data = await res.json();
    if (data.code !== 'Ok' || !data.routes?.length) throw new Error('No detour');
    return decodePolyline(data.routes[0].geometry);
}

// ── Draw real road routes on mini-map ─────────────────────────────────────
async function drawRouteOnMiniMap(lat, lng, level) {
    miniMapLayers.forEach(l => { try { miniMap.removeLayer(l); } catch(e){} });
    miniMapLayers = [];

    const key = `${lat}_${lng}`;
    const dest = ROUTE_DESTINATIONS[key] || { toLat: lat + 0.04, toLng: lng + 0.04 };

    // Loading label
    const loadingMarker = L.marker([lat, lng], {
        icon: L.divIcon({
            html: `<div style="background:#fff;border:1px solid #e8e6e1;border-radius:8px;padding:4px 8px;font-size:11px;font-weight:600;color:#555;white-space:nowrap;box-shadow:0 2px 6px rgba(0,0,0,.1)">Loading route…</div>`,
            className:'', iconSize:[120,28], iconAnchor:[60,14],
        }), interactive: false,
    }).addTo(miniMap);
    miniMapLayers.push(loadingMarker);

    try {
        const [blockedPts, altPts] = await Promise.all([
            fetchOsrmRoute(lat, lng, dest.toLat, dest.toLng),
            fetchDetourRoute(lat, lng, dest.toLat, dest.toLng),
        ]);

        try { miniMap.removeLayer(loadingMarker); } catch(e){}

        // Dashed red = congested primary route
        miniMapLayers.push(L.polyline(blockedPts, {
            color: '#ef4444', weight: 4, opacity: 0.7, dashArray: '8 5', lineCap: 'round',
        }).addTo(miniMap));

        // Solid green = alternative detour
        miniMapLayers.push(L.polyline(altPts, {
            color: '#22c55e', weight: 5, opacity: 0.95, lineCap: 'round', lineJoin: 'round',
        }).addTo(miniMap));

        // Direction arrow at midpoint of alt route
        const mid = altPts[Math.floor(altPts.length / 2)];
        if (mid) {
            miniMapLayers.push(L.marker(mid, {
                icon: L.divIcon({
                    html: `<div style="background:#22c55e;color:#fff;border-radius:50%;width:22px;height:22px;display:flex;align-items:center;justify-content:center;font-size:13px;box-shadow:0 2px 6px rgba(0,0,0,.2);">→</div>`,
                    className:'', iconSize:[22,22], iconAnchor:[11,11],
                }), interactive: false,
            }).addTo(miniMap));
        }

        // Hotspot ✕ marker
        miniMapLayers.push(L.marker([lat, lng], {
            icon: L.divIcon({
                html: `<div style="background:#ef4444;color:#fff;border-radius:50%;width:28px;height:28px;display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:700;box-shadow:0 2px 8px rgba(239,68,68,.5);border:2px solid #fff;">✕</div>`,
                className:'', iconSize:[28,28], iconAnchor:[14,14],
            }),
        }).addTo(miniMap).bindTooltip('Congestion point', { permanent:false, direction:'top' }));

        // A / B origin & destination markers
        const originPt = blockedPts[0];
        const destPt   = blockedPts[blockedPts.length - 1];
        [[originPt,'A','#3b82f6'],[destPt,'B','#8b5cf6']].forEach(([pos,label,color]) => {
            if (!pos) return;
            miniMapLayers.push(L.marker(pos, {
                icon: L.divIcon({
                    html: `<div style="background:${color};color:#fff;border-radius:50%;width:22px;height:22px;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;border:2px solid #fff;box-shadow:0 2px 6px rgba(0,0,0,.2);">${label}</div>`,
                    className:'', iconSize:[22,22], iconAnchor:[11,11],
                }), interactive: false,
            }).addTo(miniMap));
        });

        miniMap.fitBounds(L.latLngBounds([...blockedPts, ...altPts]).pad(0.15));

    } catch (err) {
        console.warn('OSRM failed, using fallback:', err.message);
        try { miniMap.removeLayer(loadingMarker); } catch(e){}
        drawFallbackRoute(lat, lng, level);
    }
}

// ── Geometric fallback if OSRM is unreachable ─────────────────────────────
function drawFallbackRoute(lat, lng, level) {
    const scale = { severe:0.04, high:0.028, moderate:0.018, low:0.012 };
    const d = scale[level] || 0.02;
    const side = Math.random() > 0.5 ? 1 : -1;
    const origin = [lat - d*1.6, lng - d*1.6];
    const dest   = [lat + d*1.6, lng + d*1.6];
    const blocked = [origin, [lat,lng], dest];
    const alt = [origin, [lat+side*d*1.3, lng-d*0.2], [lat+side*d*1.1, lng+d*0.7], dest];
    L.polyline(blocked, { color:'#ef4444', weight:4, opacity:.65, dashArray:'8 5' }).addTo(miniMap);
    L.polyline(alt,     { color:'#22c55e', weight:5, opacity:.95 }).addTo(miniMap);
    L.marker([lat,lng],{icon:L.divIcon({html:`<div style="background:#ef4444;color:#fff;border-radius:50%;width:28px;height:28px;display:flex;align-items:center;justify-content:center;font-weight:700;border:2px solid #fff;">✕</div>`,className:'',iconSize:[28,28],iconAnchor:[14,14]})}).addTo(miniMap);
    miniMap.fitBounds(L.latLngBounds([...blocked,...alt]).pad(0.2));
}

// ── Mini-map init (reused across suggestions) ─────────────────────────────
function initMiniMap(lat, lng) {
    if (!miniMap) {
        miniMap = L.map('sr-mini-map', { zoomControl:false, attributionControl:false })
            .setView([lat, lng], 14);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom:19 }).addTo(miniMap);
    } else {
        miniMap.setView([lat, lng], 14);
    }
}

// ── Suggestion modal ──────────────────────────────────────────────────────
function openSuggestModal(lat, lng, level, speed, incidents) {
    currentHotspotLat = lat; currentHotspotLng = lng;
    document.getElementById('sr-thinking').style.display = 'flex';
    document.getElementById('sr-result').classList.remove('visible');
    document.getElementById('sr-coords').textContent = `${lat.toFixed(4)}, ${lng.toFixed(4)}`;
    document.getElementById('sr-level-text').textContent = level.charAt(0).toUpperCase() + level.slice(1) + ' Congestion';
    const m = document.getElementById('suggest-modal'), b = document.getElementById('suggest-modal-box');
    m.classList.add('open');
    setTimeout(() => b.classList.add('open'), 10);
    setTimeout(() => renderSuggestion(lat, lng, level, speed, incidents), 1800 + Math.random() * 700);
}

function renderSuggestion(lat, lng, level, speed, incidents) {
    const pool = ROUTE_ALTERNATIVES[level] || ROUTE_ALTERNATIVES.moderate;
    const s = pool[Math.floor(Math.random() * pool.length)];
    const key = `${lat}_${lng}`;
    const city = NEAR_CITIES[key];
    let routeText = s.route;
    if (city) routeText = `From ${city.from}: ${city.alt}. ${s.route.split('.').slice(1).join('.').trim()}`;

    document.getElementById('sr-route-text').textContent = routeText;
    document.getElementById('sr-reason-text').textContent = s.reason;
    document.getElementById('sr-time-saved').textContent = s.timeSaved;
    document.getElementById('sr-confidence').textContent = s.confidence;
    document.getElementById('sr-avoided').textContent = s.hotspots.length;
    document.getElementById('sr-hotspots-list').innerHTML = s.hotspots.map(h => `
        <div class="sr-hotspot-item">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
            </svg>${h}
        </div>`).join('');

    document.getElementById('sr-thinking').style.display = 'none';
    document.getElementById('sr-result').classList.add('visible');

    setTimeout(async () => {
        initMiniMap(lat, lng);
        miniMap.invalidateSize();
        await drawRouteOnMiniMap(lat, lng, level);
    }, 100);
}

function openInMaps() {
    window.open(`https://www.google.com/maps?q=${currentHotspotLat},${currentHotspotLng}`, '_blank');
}

function closeSuggestModal() {
    const m = document.getElementById('suggest-modal'), b = document.getElementById('suggest-modal-box');
    b.classList.remove('open');
    setTimeout(() => m.classList.remove('open'), 200);
}

// ── Main map ──────────────────────────────────────────────────────────────
const markerColors = { low:'#10b981', moderate:'#fbbf24', high:'#f97316', severe:'#ef4444' };

function makeIcon(level) {
    const c = markerColors[level] || '#f97316';
    return L.divIcon({
        html: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36 48" width="36" height="48">
            <path d="M18 0C8.06 0 0 8.06 0 18c0 13.5 18 30 18 30s18-16.5 18-30C36 8.06 27.94 0 18 0z" fill="${c}" stroke="white" stroke-width="2"/>
            <circle cx="18" cy="18" r="8" fill="white" opacity="0.9"/>
        </svg>`,
        className:'', iconSize:[36,48], iconAnchor:[18,48], popupAnchor:[0,-48],
    });
}

let map, markers = [], mapVisible = true;

function initMap() {
    const center = hotspotsData.length
        ? [hotspotsData.reduce((s,h)=>s+h.lat,0)/hotspotsData.length, hotspotsData.reduce((s,h)=>s+h.lng,0)/hotspotsData.length]
        : [12.8797, 121.7740];

    map = L.map('hotspot-map', { center: center, zoom: 6 });
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution:'© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>', maxZoom:19
    }).addTo(map);

    hotspotsData.forEach((h, i) => {
        const marker = L.marker([h.lat,h.lng], { icon: makeIcon(h.congestion_level) })
            .addTo(map)
            .bindPopup(`<div style="min-width:180px;font-family:sans-serif">
                <div style="font-weight:700;font-size:13px;margin-bottom:6px">${h.congestion_level.charAt(0).toUpperCase()+h.congestion_level.slice(1)} Congestion</div>
                <div style="font-size:12px;color:#555;margin-bottom:4px">📍 ${h.lat.toFixed(4)}, ${h.lng.toFixed(4)}</div>
                <div style="font-size:12px;color:#555;margin-bottom:4px">🚨 <b>${h.incident_count}</b> incidents</div>
                <div style="font-size:12px;color:#555;margin-bottom:8px">🚗 Avg: <b>${h.avg_speed} km/h</b></div>
                <button onclick="openSuggestModal(${h.lat},${h.lng},'${h.congestion_level}',${h.avg_speed},${h.incident_count})"
                    style="width:100%;padding:6px;background:#d97706;color:white;border:none;border-radius:6px;font-size:12px;cursor:pointer;font-weight:600;margin-bottom:4px">
                    🧭 Suggest Route
                </button>
                <button onclick="viewHotspotData(${h.lat},${h.lng})"
                    style="width:100%;padding:5px;background:#f59e0b;color:white;border:none;border-radius:6px;font-size:12px;cursor:pointer;font-weight:600">
                    View Details
                </button>
            </div>`);

        if (['severe','high'].includes(h.congestion_level)) {
            L.circle([h.lat,h.lng], {
                color: markerColors[h.congestion_level], fillColor: markerColors[h.congestion_level],
                fillOpacity:.15, radius:300, weight:1,
            }).addTo(map);
        }
        markers.push(marker);
    });

    // FIX: invalidateSize ensures tiles render after container paints
    setTimeout(() => {
        map.invalidateSize();
        if (hotspotsData.length > 1) {
            map.fitBounds(L.featureGroup(markers).getBounds().pad(0.3));
        }
    }, 200);
}

function toggleMap() {
    const c = document.getElementById('map-container'), l = document.getElementById('toggle-map-label');
    mapVisible = !mapVisible;
    c.style.display = mapVisible ? '' : 'none';
    l.textContent = mapVisible ? 'Hide Map' : 'Show Map';
    if (mapVisible && map) setTimeout(() => map.invalidateSize(), 50);
}

document.addEventListener('DOMContentLoaded', function() {
    initMap();
    document.querySelectorAll('.hotspot-row').forEach((row, i) => {
        row.addEventListener('click', function() {
            const lat = parseFloat(this.dataset.lat), lng = parseFloat(this.dataset.lng);
            if (mapVisible) {
                document.getElementById('map-container').scrollIntoView({behavior:'smooth',block:'center'});
                setTimeout(() => { map.flyTo([lat,lng],15,{duration:1}); if(markers[i]) markers[i].openPopup(); }, 400);
            }
        });
    });
});

// ── JSON detail modal ─────────────────────────────────────────────────────
let currentJsonData = null;

function viewHotspotData(lat, lng) {
    document.getElementById('jsonModal').classList.remove('hidden');
    document.getElementById('loadingMsg').classList.remove('hidden');
    document.getElementById('jsonContent').classList.add('hidden');
    document.getElementById('hotspotLocation').textContent = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
    const url = '{{ route("traffic.hotspot-data",["latitude"=>"LAT","longitude"=>"LNG"]) }}'.replace('LAT',lat).replace('LNG',lng);
    fetch(url).then(r=>r.json()).then(d=>{currentJsonData=d;displayHotspotData(d);}).catch(()=>{document.getElementById('loadingMsg').innerHTML='<p class="text-red-600">Error.</p>';});
}

function displayHotspotData(data) {
    if (!data.success) { document.getElementById('loadingMsg').innerHTML=`<p class="text-red-600">${data.message||'No data'}</p>`; return; }
    const d = data.data;
    document.getElementById('incidentCount').textContent = d.summary.incident_count;
    document.getElementById('avgSpeed').textContent = d.summary.avg_speed.toFixed(1)+' km/h';
    const list = document.getElementById('recordsList');
    if (d.records?.length > 0) {
        list.innerHTML = d.records.slice(0,5).map(r=>`
            <div class="bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 flex items-center justify-between">
                <div><p class="text-sm font-semibold text-gray-900">${r.speed.toFixed(1)} km/h</p><p class="text-xs text-gray-500">${r.congestion_level.toUpperCase()}</p></div>
                <span class="text-xs text-gray-400">${new Date(r.timestamp).toLocaleString()}</span>
            </div>`).join('');
        if (d.records.length > 5) list.innerHTML += `<p class="text-center text-xs text-gray-400 pt-2">… and ${d.records.length-5} more</p>`;
    } else {
        list.innerHTML = '<p class="text-gray-500 text-sm">No records</p>';
    }
    document.getElementById('jsonText').textContent = JSON.stringify(data, null, 2);
    document.getElementById('loadingMsg').classList.add('hidden');
    document.getElementById('jsonContent').classList.remove('hidden');
}

function copyJsonToClipboard() {
    if (!currentJsonData) return;
    navigator.clipboard.writeText(JSON.stringify(currentJsonData,null,2)).then(()=>alert('Copied!')).catch(()=>alert('Failed'));
}

function closeModal() { document.getElementById('jsonModal').classList.add('hidden'); currentJsonData = null; }
document.getElementById('jsonModal').addEventListener('click', e => { if(e.target===document.getElementById('jsonModal')) closeModal(); });
document.addEventListener('keydown', e => { if(e.key==='Escape') { closeModal(); closeSuggestModal(); } });
</script>

@endsection