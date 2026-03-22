@extends('app')

@section('content')
<style>
    .info-cell { transition: background .15s; }
    .info-cell:hover { background: #faf7ff; }
    .action-btn { transition: all .2s ease; }
    .action-btn:hover { transform: translateY(-1px); box-shadow: 0 4px 14px rgba(0,0,0,.12); }
    .side-card { transition: transform .2s ease, box-shadow .2s ease; }
    .side-card:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(0,0,0,.08) !important; }

    /* Timeline */
    .timeline-line { position: absolute; left: 1.125rem; top: 2.5rem; bottom: 0; width: 2px; background: linear-gradient(to bottom, #e5e7eb, transparent); }
    .timeline-item:last-child .timeline-line { display: none; }
    @keyframes timeline-pop { from { transform: scale(0); opacity: 0; } to { transform: scale(1); opacity: 1; } }
    .timeline-dot { animation: timeline-pop .3s cubic-bezier(.34,1.56,.64,1) both; }

    /* AI Modal */
    @keyframes fadeIn { from { opacity:0; } to { opacity:1; } }
    @keyframes slideUp { from { transform:translateY(20px) scale(.97); opacity:0; } to { transform:translateY(0) scale(1); opacity:1; } }
    #route-modal:not(.hidden) { animation: fadeIn .2s ease; }
    #route-modal-box { animation: slideUp .25s ease; }
    .typing-dot { animation: pulse-dot 1.2s ease-in-out infinite; }
    .typing-dot:nth-child(2) { animation-delay: .2s; }
    .typing-dot:nth-child(3) { animation-delay: .4s; }
    @keyframes pulse-dot { 0%,100%{opacity:.3;transform:scale(.8);} 50%{opacity:1;transform:scale(1.1);} }
    .route-card { border-left: 4px solid #7c3aed; background: linear-gradient(135deg, #faf7ff 0%, #f3f0ff 100%); }
</style>

<div class="min-h-screen bg-gradient-to-br from-slate-50 via-purple-50 to-slate-100 px-4 py-8 md:px-8">
    <div class="max-w-7xl mx-auto">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-purple-600 to-purple-700 flex items-center justify-center shadow-lg shadow-purple-200 flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 01.553-.894L9 2m0 18l6-3m-6 3V2m6 15l6-3m-6 3V5m6 9V3m0 0l-6 3m6-3l-6 3m0 0L9 2" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 leading-tight">Trip Details</h1>
                    <p class="text-gray-500 text-sm mt-0.5">View and manage trip information</p>
                </div>
            </div>
            <a href="{{ route('trips.index') }}"
               class="action-btn inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-600 text-sm font-medium rounded-xl shadow-sm hover:bg-gray-50 self-start sm:self-auto">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to trips
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

            {{-- ── MAIN COLUMN ──────────────────────────────────── --}}
            <div class="lg:col-span-2 space-y-5">

                {{-- Trip header card --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="relative bg-gradient-to-r from-purple-600 via-purple-700 to-purple-800 px-6 pt-6 pb-16">
                        <div class="absolute top-0 right-0 w-48 h-48 bg-white opacity-5 rounded-full -translate-y-1/2 translate-x-1/4"></div>
                        <div class="absolute bottom-0 right-24 w-24 h-24 bg-white opacity-5 rounded-full translate-y-1/2"></div>
                        <div class="relative flex items-start justify-between gap-4">
                            <div>
                                <h2 class="text-xl font-bold text-white">Trip #{{ str_pad($trip->id, 4, '0', STR_PAD_LEFT) }}</h2>
                                <p class="text-purple-100 text-sm mt-1">{{ $trip->start_location }} → {{ $trip->end_location }}</p>
                            </div>
                            @if($trip->status === 'completed')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-400/20 text-emerald-100 text-xs font-semibold rounded-full border border-emerald-300/30">✓ Completed</span>
                            @elseif($trip->status === 'in_progress')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-400/20 text-blue-100 text-xs font-semibold rounded-full border border-blue-300/30">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-300 animate-pulse"></span>In Progress
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-amber-400/20 text-amber-100 text-xs font-semibold rounded-full border border-amber-300/30">Pending</span>
                            @endif
                        </div>
                    </div>

                    <div class="relative -mt-8 mx-4 mb-0 bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                        <div class="grid grid-cols-2 divide-x divide-y divide-gray-100">
                            <div class="info-cell px-5 py-4">
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1.5">Driver</p>
                                <p class="text-base font-semibold text-gray-900">{{ $trip->driver->name ?? 'Unassigned' }}</p>
                                <p class="text-xs text-gray-500">{{ $trip->driver->license_number ?? 'No license' }}</p>
                            </div>
                            <div class="info-cell px-5 py-4">
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1.5">Vehicle</p>
                                <p class="font-mono text-base font-bold text-purple-700 tracking-wider">{{ $trip->vehicle->plate_number ?? 'N/A' }}</p>
                                <p class="text-xs text-gray-500">{{ ($trip->vehicle->make ?? '') . ' ' . ($trip->vehicle->model ?? '') }}</p>
                            </div>
                            <div class="info-cell px-5 py-4">
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1.5">Start Time</p>
                                <p class="text-base font-semibold text-gray-900">{{ $trip->start_time->format('M d, Y') }}</p>
                                <p class="text-xs text-gray-500">{{ $trip->start_time->format('h:i A') }}</p>
                            </div>
                            <div class="info-cell px-5 py-4">
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1.5">End Time</p>
                                @if($trip->end_time)
                                    <p class="text-base font-semibold text-gray-900">{{ $trip->end_time->format('M d, Y') }}</p>
                                    <p class="text-xs text-gray-500">{{ $trip->end_time->format('h:i A') }}</p>
                                @else
                                    <p class="text-base font-semibold text-gray-400">Not finished</p>
                                @endif
                            </div>
                            <div class="info-cell px-5 py-4">
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1.5">Distance</p>
                                <p class="text-base font-semibold text-gray-900">{{ $trip->distance ? number_format($trip->distance, 1) . ' km' : 'N/A' }}</p>
                            </div>
                            <div class="info-cell px-5 py-4">
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1.5">Trip ID</p>
                                <p class="font-mono text-base font-bold text-purple-700">#{{ str_pad($trip->id, 4, '0', STR_PAD_LEFT) }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-end gap-2 px-6 py-4 bg-gray-50 border-t border-gray-100 mt-4">
    <a href="{{ route('trips.pdf', $trip->id) }}"
       class="action-btn inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-purple-700 bg-purple-50 hover:bg-purple-100 border border-purple-200 rounded-xl">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
        Export PDF
    </a>
    <a href="{{ route('trips.edit', $trip->id) }}"
       class="action-btn inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-amber-700 bg-amber-50 hover:bg-amber-100 border border-amber-200 rounded-xl">
        Edit Trip
    </a>
    <form action="{{ route('trips.destroy', $trip->id) }}" method="POST">
        @csrf @method('DELETE')
        <button type="submit" onclick="return confirm('Delete this trip?')"
                class="action-btn inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-red-600 bg-red-50 hover:bg-red-100 border border-red-200 rounded-xl">
            Delete
        </button>
    </form>
</div>
                </div>

                {{-- ── STATUS UPDATE CARD ──────────────────────── --}}
                @if($trip->status !== 'completed')
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-purple-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/>
                        </svg>
                        <span class="text-sm font-semibold text-gray-700">Update Trip Status</span>
                    </div>
                    <div class="px-6 py-5">
                        <div class="flex items-center mb-6">
                            @php
                                $steps = [
                                    ['key' => 'pending',     'label' => 'Pending',     'icon' => '⏳'],
                                    ['key' => 'in_progress', 'label' => 'In Progress', 'icon' => '🚛'],
                                    ['key' => 'completed',   'label' => 'Completed',   'icon' => '✓'],
                                ];
                                $order = ['pending' => 0, 'in_progress' => 1, 'completed' => 2];
                                $currentOrder = $order[$trip->status];
                            @endphp
                            @foreach($steps as $i => $step)
                                @php $stepOrder = $order[$step['key']]; @endphp
                                <div class="flex items-center {{ $i < count($steps) - 1 ? 'flex-1' : '' }}">
                                    <div class="flex flex-col items-center">
                                        <div class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold border-2 transition-all
                                            {{ $stepOrder < $currentOrder ? 'bg-purple-600 border-purple-600 text-white' :
                                               ($stepOrder === $currentOrder ? 'bg-purple-100 border-purple-500 text-purple-700' :
                                               'bg-gray-100 border-gray-300 text-gray-400') }}">
                                            {{ $stepOrder < $currentOrder ? '✓' : $step['icon'] }}
                                        </div>
                                        <p class="text-xs font-medium mt-1.5
                                            {{ $stepOrder === $currentOrder ? 'text-purple-700' : ($stepOrder < $currentOrder ? 'text-purple-500' : 'text-gray-400') }}">
                                            {{ $step['label'] }}
                                        </p>
                                    </div>
                                    @if($i < count($steps) - 1)
                                        <div class="flex-1 h-0.5 mx-2 mb-4 {{ $stepOrder < $currentOrder ? 'bg-purple-400' : 'bg-gray-200' }}"></div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <div class="flex flex-wrap gap-3">
                            @if($trip->status === 'pending')
                                <form action="{{ route('trips.update-status', $trip->id) }}" method="POST" class="flex-1">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="in_progress">
                                    <button type="submit" class="action-btn w-full inline-flex items-center justify-center gap-2 px-5 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white text-sm font-bold rounded-xl shadow-md shadow-blue-200 hover:shadow-lg hover:-translate-y-0.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z"/>
                                        </svg>
                                        Start Trip
                                    </button>
                                </form>
                            @endif
                            @if($trip->status === 'in_progress')
                                <form action="{{ route('trips.update-status', $trip->id) }}" method="POST" class="flex-1">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="completed">
                                    <button type="submit" onclick="return confirm('Mark this trip as completed?')"
                                            class="action-btn w-full inline-flex items-center justify-center gap-2 px-5 py-3 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white text-sm font-bold rounded-xl shadow-md shadow-emerald-200 hover:shadow-lg hover:-translate-y-0.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Complete Trip
                                    </button>
                                </form>
                            @endif
                        </div>
                        @if($trip->status === 'in_progress')
                            <p class="text-xs text-gray-400 mt-3 text-center">
                                Trip started {{ $trip->start_time->setTimezone(config('app.timezone'))->diffForHumans() }} · Completing will record the end time automatically
                            </p>
                        @endif
                    </div>
                </div>
                @else
                <div class="bg-emerald-50 border border-emerald-200 rounded-2xl px-6 py-5 flex items-center gap-4">
                    <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-emerald-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-emerald-800">Trip Completed</p>
                        <p class="text-xs text-emerald-600 mt-0.5">
                            Ended {{ $trip->end_time?->format('M d, Y h:i A') ?? 'N/A' }}
                            @if($trip->start_time && $trip->end_time)
                                · Duration: {{ $trip->start_time->diffInMinutes($trip->end_time) }} minutes
                            @endif
                        </p>
                    </div>
                </div>
                @endif

                {{-- ── TRIP TIMELINE ───────────────────────────── --}}
                @php
    $timelineEvents = [];

    // 1. Trip created
    $timelineEvents[] = [
        'type'  => 'created',
        'title' => 'Trip Created',
        'desc'  => 'Trip scheduled from ' . $trip->start_location . ' to ' . $trip->end_location,
        'time'  => $trip->created_at,
        'color' => 'violet',
        'icon'  => 'plus',
    ];

    // 2. Driver & vehicle assigned
    $timelineEvents[] = [
        'type'  => 'assigned',
        'title' => 'Driver & Vehicle Assigned',
        'desc'  => ($trip->driver->name ?? 'Unknown driver') . ' assigned with ' . ($trip->vehicle->plate_number ?? 'unknown vehicle'),
        'time'  => $trip->created_at,
        'color' => 'blue',
        'icon'  => 'user',
    ];

    // 3. Trip started
    if(in_array($trip->status, ['in_progress', 'completed'])) {
        $timelineEvents[] = [
            'type'  => 'started',
            'title' => 'Trip Started',
            'desc'  => 'Departed from ' . $trip->start_location,
            'time'  => $trip->updated_at, // use updated_at as proxy for when status changed
            'color' => 'blue',
            'icon'  => 'play',
        ];
    }

    // 4. Traffic alerts — GROUP by 10-minute windows, show max 3
    try {
        $trafficAlerts = $trip->trafficData()
            ->whereIn('congestion_level', ['high', 'severe'])
            ->orderBy('timestamp')
            ->get();

        // Group alerts into clusters (10-minute windows)
        $clusters = [];
        foreach ($trafficAlerts as $alert) {
            $placed = false;
            foreach ($clusters as &$cluster) {
                $lastTime = end($cluster)->timestamp;
                if ($alert->timestamp->diffInMinutes($lastTime) <= 10) {
                    $cluster[] = $alert;
                    $placed = true;
                    break;
                }
            }
            if (!$placed) {
                $clusters[] = [$alert];
            }
        }

        // Take max 3 clusters to avoid flooding
        foreach (array_slice($clusters, 0, 3) as $cluster) {
            $worst     = collect($cluster)->sortByDesc(fn($a) => $a->congestion_level === 'severe' ? 1 : 0)->first();
            $isSevere  = $worst->congestion_level === 'severe';
            $count     = count($cluster);
            $avgSpeed  = collect($cluster)->avg('speed');
            $timelineEvents[] = [
                'type'  => 'traffic',
                'title' => $isSevere ? '🚨 Severe Congestion Detected' : '⚠️ High Traffic Alert',
                'desc'  => 'Average speed ' . number_format($avgSpeed, 1) . ' km/h' .
                           ($count > 1 ? ' · ' . $count . ' incidents in this period' : '') .
                           ' — ' . ucfirst($worst->congestion_level) . ' congestion',
                'time'  => $worst->timestamp,
                'color' => $isSevere ? 'red' : 'orange',
                'icon'  => 'alert',
            ];
        }

        // If more than 3 clusters, add a summary event
        if (count($clusters) > 3) {
            $remaining = count($clusters) - 3;
            $timelineEvents[] = [
                'type'  => 'traffic',
                'title' => '⚠️ ' . $remaining . ' more congestion period' . ($remaining > 1 ? 's' : ''),
                'desc'  => 'Additional traffic incidents detected along the route',
                'time'  => collect(array_slice($clusters, 3))->last()[0]->timestamp,
                'color' => 'orange',
                'icon'  => 'alert',
            ];
        }
    } catch(\Exception $e) {}

    // 5. Route recommendation accepted
    try {
        $accepted = \App\Models\RouteRecommendation::where('trip_id', $trip->id)
            ->where('accepted_by_driver', true)
            ->orderBy('created_at')
            ->get();
        foreach ($accepted as $rec) {
            $timelineEvents[] = [
                'type'  => 'route',
                'title' => 'Alternative Route Accepted',
                'desc'  => 'Driver accepted: ' . $rec->alternative_route . ' — saved ~' . number_format($rec->estimated_time_saved, 0) . ' min',
                'time'  => $rec->created_at,
                'color' => 'emerald',
                'icon'  => 'route',
            ];
        }
    } catch(\Exception $e) {}

    // 6. Trip completed
    if($trip->status === 'completed' && $trip->end_time) {
        $duration = $trip->start_time->diffInMinutes($trip->end_time);
        $timelineEvents[] = [
            'type'  => 'completed',
            'title' => 'Trip Completed',
            'desc'  => 'Arrived at ' . $trip->end_location . ' · Total duration: ' . $duration . ' minutes' . ($trip->distance ? ' · ' . number_format($trip->distance, 1) . ' km' : ''),
            'time'  => $trip->end_time,
            'color' => 'emerald',
            'icon'  => 'check',
        ];
    }

    // Sort all events by time ascending
    usort($timelineEvents, fn($a, $b) => $a['time'] <=> $b['time']);
@endphp

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-sm font-semibold text-gray-700">Trip Timeline</span>
                            <span class="ml-1 px-2 py-0.5 text-xs font-semibold bg-purple-100 text-purple-700 rounded-full">{{ count($timelineEvents) }}</span>
                        </div>
                        @if($trip->status === 'in_progress')
                            <span class="inline-flex items-center gap-1.5 text-xs font-medium text-blue-600">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                                Live
                            </span>
                        @endif
                    </div>

                    <div class="px-6 py-5">
                        <div class="space-y-0">
                            @foreach($timelineEvents as $i => $event)
                                @php
                                    $colorMap = [
                                        'violet'  => ['dot' => 'bg-violet-500',  'ring' => 'ring-violet-200',  'icon_bg' => 'bg-violet-100',  'icon_color' => 'text-violet-600',  'badge' => 'bg-violet-50 text-violet-700 border-violet-100'],
                                        'blue'    => ['dot' => 'bg-blue-500',    'ring' => 'ring-blue-200',    'icon_bg' => 'bg-blue-100',    'icon_color' => 'text-blue-600',    'badge' => 'bg-blue-50 text-blue-700 border-blue-100'],
                                        'emerald' => ['dot' => 'bg-emerald-500', 'ring' => 'ring-emerald-200', 'icon_bg' => 'bg-emerald-100', 'icon_color' => 'text-emerald-600', 'badge' => 'bg-emerald-50 text-emerald-700 border-emerald-100'],
                                        'red'     => ['dot' => 'bg-red-500',     'ring' => 'ring-red-200',     'icon_bg' => 'bg-red-100',     'icon_color' => 'text-red-600',     'badge' => 'bg-red-50 text-red-700 border-red-100'],
                                        'orange'  => ['dot' => 'bg-orange-500',  'ring' => 'ring-orange-200',  'icon_bg' => 'bg-orange-100',  'icon_color' => 'text-orange-600',  'badge' => 'bg-orange-50 text-orange-700 border-orange-100'],
                                    ];
                                    $c = $colorMap[$event['color']] ?? $colorMap['blue'];
                                    $isLast = $i === count($timelineEvents) - 1;
                                @endphp
                                <div class="timeline-item relative flex gap-4 {{ $isLast ? 'pb-0' : 'pb-6' }}" style="animation-delay: {{ $i * 0.08 }}s">
                                    {{-- Vertical line --}}
                                    @if(!$isLast)
                                        <div class="timeline-line"></div>
                                    @endif

                                    {{-- Dot --}}
                                    <div class="flex-shrink-0 relative z-10 mt-0.5">
                                        <div class="timeline-dot w-9 h-9 rounded-full {{ $c['icon_bg'] }} ring-4 {{ $c['ring'] }} flex items-center justify-center" style="animation-delay: {{ $i * 0.08 }}s">
                                            @if($event['icon'] === 'plus')
                                                <svg class="w-4 h-4 {{ $c['icon_color'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                                </svg>
                                            @elseif($event['icon'] === 'user')
                                                <svg class="w-4 h-4 {{ $c['icon_color'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                </svg>
                                            @elseif($event['icon'] === 'play')
                                                <svg class="w-4 h-4 {{ $c['icon_color'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z"/>
                                                </svg>
                                            @elseif($event['icon'] === 'alert')
                                                <svg class="w-4 h-4 {{ $c['icon_color'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z"/>
                                                </svg>
                                            @elseif($event['icon'] === 'route')
                                                <svg class="w-4 h-4 {{ $c['icon_color'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 01.553-.894L9 2m0 18l6-3m-6 3V2m6 15l6-3m-6 3V5m6 9V3"/>
                                                </svg>
                                            @elseif($event['icon'] === 'check')
                                                <svg class="w-4 h-4 {{ $c['icon_color'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                                </svg>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Content --}}
                                    <div class="flex-1 min-w-0 pt-1">
                                        <div class="flex items-start justify-between gap-2 flex-wrap">
                                            <p class="text-sm font-semibold text-gray-900">{{ $event['title'] }}</p>
                                            <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium rounded-full border {{ $c['badge'] }} flex-shrink-0">
                                                {{ $event['time']->format('h:i A') }}
                                            </span>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1 leading-relaxed">{{ $event['desc'] }}</p>
                                        <p class="text-xs text-gray-400 mt-1">{{ $event['time']->format('M d, Y') }} · {{ $event['time']->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @endforeach

                            {{-- Future: pending events for in_progress trips --}}
                            @if($trip->status === 'in_progress')
                                <div class="relative flex gap-4 pt-2">
                                    <div class="flex-shrink-0">
                                        <div class="w-9 h-9 rounded-full bg-gray-100 ring-4 ring-gray-100 flex items-center justify-center">
                                            <span class="w-2 h-2 rounded-full bg-gray-300 animate-pulse"></span>
                                        </div>
                                    </div>
                                    <div class="flex-1 pt-2">
                                        <p class="text-sm font-medium text-gray-400">Waiting for trip completion...</p>
                                        <p class="text-xs text-gray-300 mt-0.5">End time and duration will be recorded here</p>
                                    </div>
                                </div>
                            @elseif($trip->status === 'pending')
                                <div class="relative flex gap-4 pt-2">
                                    <div class="flex-shrink-0">
                                        <div class="w-9 h-9 rounded-full bg-gray-100 ring-4 ring-gray-100 flex items-center justify-center">
                                            <span class="w-2 h-2 rounded-full bg-gray-300 animate-pulse"></span>
                                        </div>
                                    </div>
                                    <div class="flex-1 pt-2">
                                        <p class="text-sm font-medium text-gray-400">Trip not started yet</p>
                                        <p class="text-xs text-gray-300 mt-0.5">Events will appear here once the trip begins</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- AI Route Suggestion Banner --}}
                @if(in_array($trip->status, ['in_progress', 'pending']))
                <div class="bg-gradient-to-r from-violet-600 to-purple-700 rounded-2xl p-5 shadow-lg shadow-purple-200">
                    <div class="flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-white font-semibold text-sm">AI Route Optimizer</p>
                                <p class="text-purple-200 text-xs mt-0.5">Analyze current hotspots and get a smarter route suggestion</p>
                            </div>
                        </div>
                        <button onclick="getRouteSuggestion()"
                                class="action-btn flex-shrink-0 inline-flex items-center gap-2 px-5 py-2.5 bg-white text-purple-700 text-sm font-bold rounded-xl shadow-md hover:shadow-lg hover:bg-purple-50 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.59 14.37a6 6 0 01-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 006.16-12.12A14.98 14.98 0 009.631 8.41m5.96 5.96a14.926 14.926 0 01-5.841 2.58m-.119-8.54a6 6 0 00-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 00-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 01-2.448-2.448 14.9 14.9 0 01.06-.312m-2.24 2.39a4.493 4.493 0 00-1.757 4.306 4.493 4.493 0 004.306-1.758M16.5 9a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                            </svg>
                            Suggest Route
                        </button>
                    </div>
                </div>
                @endif

            </div>

            {{-- ── SIDEBAR ───────────────────────────────────────── --}}
            <div class="space-y-4">

                {{-- Record Info --}}
                <div class="side-card bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-5 py-3.5 border-b border-gray-100 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-gray-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-sm font-semibold text-gray-700">Record Info</span>
                    </div>
                    <div class="divide-y divide-gray-50 px-5">
                        <div class="py-3.5">
                            <p class="text-xs text-gray-400 font-medium">Created</p>
                            <p class="text-sm font-semibold text-gray-900 mt-0.5">{{ $trip->created_at->format('M d, Y h:i A') }}</p>
                        </div>
                        <div class="py-3.5">
                            <p class="text-xs text-gray-400 font-medium">Last Updated</p>
                            <p class="text-sm font-semibold text-gray-900 mt-0.5">{{ $trip->updated_at->format('M d, Y h:i A') }}</p>
                        </div>
                        @if($trip->start_time && $trip->end_time)
                        <div class="py-3.5">
                            <p class="text-xs text-gray-400 font-medium">Duration</p>
                            <p class="text-sm font-semibold text-gray-900 mt-0.5">{{ $trip->start_time->diffInMinutes($trip->end_time) }} minutes</p>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Traffic Status --}}
                <div class="side-card bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-5 py-3.5 border-b border-gray-100 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-amber-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/>
                        </svg>
                        <span class="text-sm font-semibold text-gray-700">Traffic Status</span>
                    </div>
                    <div class="px-5 py-4">
                        @php $latestTraffic = $trip->trafficData()->latest('timestamp')->first(); @endphp
                        @if($latestTraffic)
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-xs text-gray-500">Current Speed</span>
                                    <span class="text-sm font-bold text-gray-900">{{ number_format($latestTraffic->speed, 1) }} km/h</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-xs text-gray-500">Congestion</span>
                                    @php $level = $latestTraffic->congestion_level; @endphp
                                    <span class="px-2 py-0.5 text-xs font-semibold rounded-full
                                        {{ $level === 'severe' ? 'bg-red-100 text-red-700' : ($level === 'high' ? 'bg-orange-100 text-orange-700' : ($level === 'moderate' ? 'bg-yellow-100 text-yellow-700' : 'bg-emerald-100 text-emerald-700')) }}">
                                        {{ ucfirst($level) }}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-xs text-gray-500">Last Update</span>
                                    <span class="text-xs text-gray-700">{{ $latestTraffic->timestamp->diffForHumans() }}</span>
                                </div>
                            </div>
                        @else
                            <p class="text-xs text-gray-400 text-center py-2">No traffic data recorded yet</p>
                        @endif
                    </div>
                </div>

                {{-- Timeline Summary --}}
                <div class="side-card bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-5 py-3.5 border-b border-gray-100 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <span class="text-sm font-semibold text-gray-700">Trip Summary</span>
                    </div>
                    <div class="divide-y divide-gray-50 px-5">
                        @php
                            $trafficCount = 0;
                            $routeCount   = 0;
                            try { $trafficCount = $trip->trafficData()->whereIn('congestion_level', ['high','severe'])->count(); } catch(\Exception $e) {}
                            try { $routeCount = \App\Models\RouteRecommendation::where('trip_id', $trip->id)->where('accepted_by_driver', true)->count(); } catch(\Exception $e) {}
                        @endphp
                        <div class="py-3 flex items-center justify-between">
                            <span class="text-xs text-gray-500">Total Events</span>
                            <span class="text-sm font-bold text-gray-900">{{ count($timelineEvents) }}</span>
                        </div>
                        <div class="py-3 flex items-center justify-between">
                            <span class="text-xs text-gray-500">Traffic Alerts</span>
                            <span class="text-sm font-bold {{ $trafficCount > 0 ? 'text-red-600' : 'text-gray-900' }}">{{ $trafficCount }}</span>
                        </div>
                        <div class="py-3 flex items-center justify-between">
                            <span class="text-xs text-gray-500">Routes Accepted</span>
                            <span class="text-sm font-bold {{ $routeCount > 0 ? 'text-emerald-600' : 'text-gray-900' }}">{{ $routeCount }}</span>
                        </div>
                        <div class="py-3 flex items-center justify-between">
                            <span class="text-xs text-gray-500">Trip Status</span>
                            <span class="text-xs font-semibold px-2 py-0.5 rounded-full
                                {{ $trip->status === 'completed' ? 'bg-emerald-100 text-emerald-700' : ($trip->status === 'in_progress' ? 'bg-blue-100 text-blue-700' : 'bg-amber-100 text-amber-700') }}">
                                {{ ucfirst(str_replace('_', ' ', $trip->status)) }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Quick links --}}
                <a href="{{ route('traffic.dashboard') }}"
                   class="side-card flex items-center gap-3 bg-white rounded-2xl shadow-sm border border-gray-100 px-5 py-4 hover:border-amber-200 transition-colors">
                    <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-amber-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c-.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-700">Traffic Dashboard</p>
                        <p class="text-xs text-gray-400">View all active vehicles</p>
                    </div>
                </a>

            </div>
       </div>
    </div>

    {{-- ── MAP CARD ─────────────────────────────────────── --}}
    @php
        $startLocation = urlencode($trip->start_location);
        $endLocation   = urlencode($trip->end_location);
        $hotspotCoords = [];
        try {
            $hotspotCoords = $trip->trafficData()
                ->whereIn('congestion_level', ['high', 'severe'])
                ->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->orderBy('timestamp')
                ->get(['latitude', 'longitude', 'congestion_level', 'speed'])
                ->unique(fn($t) => round($t->latitude, 3) . ',' . round($t->longitude, 3))
                ->take(10)
                ->values();
        } catch(\Exception $e) {}
    @endphp

    <div class="max-w-7xl mx-auto mt-6">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

@php
    $startLocation = urlencode($trip->start_location);
    $endLocation   = urlencode($trip->end_location);

    // Try to get traffic hotspot coordinates for this trip
    $hotspotCoords = [];
    try {
        $hotspotCoords = $trip->trafficData()
            ->whereIn('congestion_level', ['high', 'severe'])
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->orderBy('timestamp')
            ->get(['latitude', 'longitude', 'congestion_level', 'speed'])
            ->unique(fn($t) => round($t->latitude, 3) . ',' . round($t->longitude, 3))
            ->take(10)
            ->values();
    } catch(\Exception $e) {}
@endphp

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 01.553-.894L9 2m0 18l6-3m-6 3V2m6 15l6-3m-6 3V5m6 9V3m0 0l-6 3m6-3l-6 3m0 0L9 2"/>
            </svg>
            <span class="text-sm font-semibold text-gray-700">Route Map</span>
        </div>
        <div class="flex items-center gap-2">
            {{-- Legend --}}
            <div class="hidden sm:flex items-center gap-3 text-xs text-gray-500">
                <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500 inline-block"></span> Start</span>
                <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-full bg-red-500 inline-block"></span> End</span>
                <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-full bg-orange-400 inline-block"></span> Hotspot</span>
            </div>
            <a href="https://www.google.com/maps/dir/{{ $startLocation }}/{{ $endLocation }}"
               target="_blank"
               class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-purple-700 bg-purple-50 hover:bg-purple-100 border border-purple-200 rounded-lg transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
                Open in Google Maps
            </a>
        </div>
    </div>

    {{-- Route info bar --}}
    <div class="px-6 py-3 bg-gray-50 border-b border-gray-100 flex items-center gap-6 text-xs text-gray-600 flex-wrap">
        <div class="flex items-center gap-2">
            <div class="w-5 h-5 rounded-full bg-emerald-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-3 h-3 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                    <circle cx="10" cy="10" r="4"/>
                </svg>
            </div>
            <span class="font-medium text-gray-900">{{ $trip->start_location }}</span>
        </div>
        <div class="flex items-center gap-1 text-gray-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
            </svg>
            <span id="route-info-distance">
                @if($trip->distance)
                    {{ number_format($trip->distance, 1) }} km
                @else
                    Calculating...
                @endif
            </span>
        </div>
        <div class="flex items-center gap-2">
            <div class="w-5 h-5 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-3 h-3 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                </svg>
            </div>
            <span class="font-medium text-gray-900">{{ $trip->end_location }}</span>
        </div>
        @if(count($hotspotCoords) > 0)
            <div class="ml-auto flex items-center gap-1.5 text-orange-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z"/>
                </svg>
                <span class="font-medium">{{ count($hotspotCoords) }} traffic hotspot{{ count($hotspotCoords) > 1 ? 's' : '' }} detected</span>
            </div>
        @endif
    </div>

    {{-- Leaflet Map --}}
    <div id="trip-map" style="height: 380px; width: 100%;"></div>

    {{-- Map footer --}}
    <div class="px-6 py-3 bg-gray-50 border-t border-gray-100 flex items-center justify-between text-xs text-gray-400">
        <span>Map data © OpenStreetMap contributors</span>
        <span>Route follows actual roads via OSRM</span>
    </div>
</div>
</div>{{-- end max-w-7xl --}}
</div>{{-- end min-h-screen --}}

{{-- Leaflet CSS & JS --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
document.addEventListener('DOMContentLoaded', async function() {
    const startName = @json($trip->start_location);
    const endName   = @json($trip->end_location);
    const hotspots  = @json($hotspotCoords);

    // ── Geocode a place name using Nominatim ──────────────────
    async function geocode(name) {
        try {
            const res  = await fetch(`https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(name)}&format=json&limit=1`, {
                headers: { 'Accept-Language': 'en' }
            });
            const data = await res.json();
            if (data.length > 0) return { lat: parseFloat(data[0].lat), lng: parseFloat(data[0].lon) };
        } catch(e) {}
        return null;
    }

    const [startCoords, endCoords] = await Promise.all([geocode(startName), geocode(endName)]);

    if (!startCoords || !endCoords) {
        document.getElementById('trip-map').innerHTML = `
            <div class="flex flex-col items-center justify-center h-full bg-gray-50 text-center p-6">
                <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center mb-3">
                    <svg class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 01.553-.894L9 2m0 18l6-3m-6 3V2m6 15l6-3m-6 3V5"/>
                    </svg>
                </div>
                <p class="text-sm font-semibold text-gray-600">Could not locate route on map</p>
                <p class="text-xs text-gray-400 mt-1">Try opening in Google Maps instead</p>
            </div>`;
        return;
    }

    // ── Initialize map ────────────────────────────────────────
    const map = L.map('trip-map', { zoomControl: true, scrollWheelZoom: false });

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 18,
    }).addTo(map);

    // ── Custom markers ────────────────────────────────────────
    function makeMarker(color, letter) {
        return L.divIcon({
            className: '',
            html: `<div style="
                width:36px; height:36px; border-radius:50% 50% 50% 0;
                background:${color}; border:3px solid white;
                box-shadow:0 3px 10px rgba(0,0,0,.25);
                transform:rotate(-45deg);
                display:flex; align-items:center; justify-content:center;">
                <span style="transform:rotate(45deg); color:white; font-weight:800; font-size:13px;">${letter}</span>
            </div>`,
            iconSize: [36, 36],
            iconAnchor: [18, 36],
            popupAnchor: [0, -36],
        });
    }

    function makeHotspotMarker(isSevere) {
        const color = isSevere ? '#ef4444' : '#f97316';
        return L.divIcon({
            className: '',
            html: `<div style="
                width:28px; height:28px; border-radius:50%;
                background:${color}; border:3px solid white;
                box-shadow:0 2px 8px rgba(0,0,0,.25);
                display:flex; align-items:center; justify-content:center;">
                <span style="color:white; font-size:13px; line-height:1;">⚠</span>
            </div>`,
            iconSize: [28, 28],
            iconAnchor: [14, 14],
            popupAnchor: [0, -14],
        });
    }

    // ── Add start marker ──────────────────────────────────────
    L.marker([startCoords.lat, startCoords.lng], { icon: makeMarker('#16a34a', 'A') })
        .addTo(map)
        .bindPopup(`
            <div style="min-width:160px;">
                <p style="font-weight:700; font-size:13px; color:#111827; margin:0 0 4px;">🟢 Start Point</p>
                <p style="font-size:12px; color:#374151; margin:0;">${startName}</p>
            </div>`, { maxWidth: 200 });

    // ── Add end marker ────────────────────────────────────────
    L.marker([endCoords.lat, endCoords.lng], { icon: makeMarker('#dc2626', 'B') })
        .addTo(map)
        .bindPopup(`
            <div style="min-width:160px;">
                <p style="font-weight:700; font-size:13px; color:#111827; margin:0 0 4px;">🔴 End Point</p>
                <p style="font-size:12px; color:#374151; margin:0;">${endName}</p>
            </div>`, { maxWidth: 200 });

    // ── Draw road-following route via OSRM ────────────────────
async function drawRoute(start, end) {
    try {
        const url = `https://router.project-osrm.org/route/v1/driving/${start.lng},${start.lat};${end.lng},${end.lat}?overview=full&geometries=geojson`;
        const res  = await fetch(url);
        const data = await res.json();

        if (data.code === 'Ok' && data.routes.length > 0) {
            const route    = data.routes[0];
            const coords   = route.geometry.coordinates.map(c => [c[1], c[0]]);
            const distance = (route.distance / 1000).toFixed(1);
            const duration = Math.round(route.duration / 60);

            // Draw the road-following polyline
            L.polyline(coords, {
                color: '#7c3aed',
                weight: 5,
                opacity: 0.8,
            }).addTo(map);

            // Draw a subtle shadow line underneath
            L.polyline(coords, {
                color: '#4c1d95',
                weight: 8,
                opacity: 0.15,
            }).addTo(map);

            // Update the route info bar dynamically
            const infoBar = document.getElementById('route-info-distance');
            if (infoBar) {
                infoBar.textContent = `${distance} km · ~${duration} min drive`;
            }
        } else {
            // Fallback to straight line if OSRM fails
            L.polyline(
                [[start.lat, start.lng], [end.lat, end.lng]],
                { color: '#7c3aed', weight: 4, opacity: 0.75, dashArray: '8, 6' }
            ).addTo(map);
        }
    } catch(e) {
        // Fallback to straight line on network error
        L.polyline(
            [[start.lat, start.lng], [end.lat, end.lng]],
            { color: '#7c3aed', weight: 4, opacity: 0.75, dashArray: '8, 6' }
        ).addTo(map);
    }
}

await drawRoute(startCoords, endCoords);

    // ── Add hotspot markers ───────────────────────────────────
    hotspots.forEach(h => {
        if (h.latitude && h.longitude) {
            const isSevere = h.congestion_level === 'severe';
            L.marker([h.latitude, h.longitude], { icon: makeHotspotMarker(isSevere) })
                .addTo(map)
                .bindPopup(`
                    <div style="min-width:160px;">
                        <p style="font-weight:700; font-size:13px; color:#111827; margin:0 0 4px;">
                            ${isSevere ? '🚨 Severe Congestion' : '⚠️ High Traffic'}
                        </p>
                        <p style="font-size:12px; color:#374151; margin:0;">Speed: <strong>${parseFloat(h.speed).toFixed(1)} km/h</strong></p>
                        <p style="font-size:11px; color:#6b7280; margin:4px 0 0;">Level: ${h.congestion_level}</p>
                    </div>`, { maxWidth: 200 });
        }
    });

    // ── Fit map bounds to show all markers ────────────────────
    const bounds = L.latLngBounds([
        [startCoords.lat, startCoords.lng],
        [endCoords.lat, endCoords.lng],
        ...hotspots.filter(h => h.latitude && h.longitude).map(h => [h.latitude, h.longitude])
    ]);
    map.fitBounds(bounds, { padding: [40, 40] });

    // ── Enable scroll zoom on click ───────────────────────────
    map.on('click', () => map.scrollWheelZoom.enable());
    map.on('mouseout', () => map.scrollWheelZoom.disable());
});
</script>

{{-- AI Route Suggestion Modal --}}
<div id="route-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4"
     style="background:rgba(0,0,0,.5); backdrop-filter:blur(4px);">
    <div id="route-modal-box" class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden">
        <div class="bg-gradient-to-r from-violet-600 to-purple-700 px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-white font-bold text-sm">AI Route Suggestion</p>
                    <p class="text-purple-200 text-xs">Trip #{{ str_pad($trip->id, 4, '0', STR_PAD_LEFT) }} · {{ $trip->start_location }} → {{ $trip->end_location }}</p>
                </div>
            </div>
            <button onclick="closeRouteModal()" class="text-white/70 hover:text-white text-2xl leading-none">&times;</button>
        </div>

        <div id="modal-loading" class="px-6 py-10 text-center">
            <div class="flex items-center justify-center gap-1 mb-4">
                <span class="typing-dot w-2.5 h-2.5 bg-purple-500 rounded-full inline-block"></span>
                <span class="typing-dot w-2.5 h-2.5 bg-purple-500 rounded-full inline-block"></span>
                <span class="typing-dot w-2.5 h-2.5 bg-purple-500 rounded-full inline-block"></span>
            </div>
            <p class="text-gray-600 font-medium text-sm">Analyzing traffic hotspots...</p>
            <p class="text-gray-400 text-xs mt-1">Finding the best alternative route for you</p>
        </div>

        <div id="modal-result" class="hidden px-6 py-5 space-y-4">
            <div class="route-card rounded-xl p-4">
                <div class="flex items-center gap-2 mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-purple-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.59 14.37a6 6 0 01-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 006.16-12.12A14.98 14.98 0 009.631 8.41m5.96 5.96a14.926 14.926 0 01-5.841 2.58m-.119-8.54a6 6 0 00-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 00-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 01-2.448-2.448 14.9 14.9 0 01.06-.312m-2.24 2.39a4.493 4.493 0 00-1.757 4.306 4.493 4.493 0 004.306-1.758M16.5 9a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                    </svg>
                    <span class="text-xs font-bold text-purple-700 uppercase tracking-wider">Suggested Route</span>
                </div>
                <p id="result-route" class="text-gray-900 font-semibold text-sm leading-relaxed"></p>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div class="bg-emerald-50 border border-emerald-100 rounded-xl p-3 text-center">
                    <p class="text-xs text-gray-500 mb-1">Est. Time Saved</p>
                    <p id="result-time-saved" class="text-xl font-bold text-emerald-600"></p>
                </div>
                <div class="bg-blue-50 border border-blue-100 rounded-xl p-3 text-center">
                    <p class="text-xs text-gray-500 mb-1">Confidence</p>
                    <p id="result-confidence" class="text-xl font-bold text-blue-600"></p>
                </div>
            </div>
            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Why this route?</p>
                <p id="result-reason" class="text-sm text-gray-700 leading-relaxed"></p>
            </div>
            <div id="hotspots-section" class="hidden">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Hotspots Avoided</p>
                <div id="result-hotspots" class="space-y-1.5"></div>
            </div>
            <div class="flex gap-2 pt-1">
                <button onclick="getRouteSuggestion()" class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-semibold text-purple-700 bg-purple-50 hover:bg-purple-100 border border-purple-200 rounded-xl transition-colors">Regenerate</button>
                <button onclick="closeRouteModal()" class="flex-1 inline-flex items-center justify-center px-4 py-2.5 text-sm font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">Close</button>
            </div>
        </div>

        <div id="modal-error" class="hidden px-6 py-8 text-center">
            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-red-500">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                </svg>
            </div>
            <p class="text-gray-800 font-semibold text-sm mb-1">Could not get suggestion</p>
            <p id="modal-error-msg" class="text-gray-500 text-xs mb-4"></p>
            <button onclick="getRouteSuggestion()" class="px-4 py-2 text-sm font-medium text-purple-700 bg-purple-50 border border-purple-200 rounded-lg hover:bg-purple-100">Try Again</button>
        </div>
    </div>
</div>

<script>
    const SUGGEST_URL = '{{ route("traffic.suggest-route", $trip->id) }}';

    function getRouteSuggestion() {
        document.getElementById('route-modal').classList.remove('hidden');
        showLoading();
        fetch(SUGGEST_URL, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        })
        .then(r => r.json())
        .then(data => { data.success ? showResult(data) : showError(data.message || 'Something went wrong.'); })
        .catch(() => showError('Network error. Please try again.'));
    }

    function showLoading() {
        document.getElementById('modal-loading').classList.remove('hidden');
        document.getElementById('modal-result').classList.add('hidden');
        document.getElementById('modal-error').classList.add('hidden');
    }

    function showResult(data) {
        document.getElementById('modal-loading').classList.add('hidden');
        document.getElementById('modal-error').classList.add('hidden');
        document.getElementById('modal-result').classList.remove('hidden');
        document.getElementById('result-route').textContent      = data.alternative_route;
        document.getElementById('result-time-saved').textContent = data.time_saved;
        document.getElementById('result-confidence').textContent = data.confidence;
        document.getElementById('result-reason').textContent     = data.reason;
        if (data.hotspots_avoided?.length > 0) {
            document.getElementById('hotspots-section').classList.remove('hidden');
            document.getElementById('result-hotspots').innerHTML = data.hotspots_avoided.map(h =>
                `<div class="flex items-center gap-2 bg-red-50 border border-red-100 rounded-lg px-3 py-2">
                    <span class="w-2 h-2 rounded-full bg-red-500 flex-shrink-0"></span>
                    <span class="text-xs text-red-700 font-medium">${h}</span>
                </div>`).join('');
        } else {
            document.getElementById('hotspots-section').classList.add('hidden');
        }
    }

    function showError(msg) {
        document.getElementById('modal-loading').classList.add('hidden');
        document.getElementById('modal-result').classList.add('hidden');
        document.getElementById('modal-error').classList.remove('hidden');
        document.getElementById('modal-error-msg').textContent = msg;
    }

    function closeRouteModal() { document.getElementById('route-modal').classList.add('hidden'); }
    document.getElementById('route-modal').addEventListener('click', e => { if (e.target === document.getElementById('route-modal')) closeRouteModal(); });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeRouteModal(); });
</script>
@endsection