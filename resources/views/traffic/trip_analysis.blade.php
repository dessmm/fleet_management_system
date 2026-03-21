@extends('app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-amber-50 to-slate-100 py-8">
<div class="max-w-7xl mx-auto px-4 md:px-8">
    
    <div class="mb-8">
        <a href="{{ route('traffic.dashboard') }}" class="text-amber-600 hover:text-amber-800 text-sm font-medium mb-4 inline-block">
            ← Back to Dashboard
        </a>
        <h1 class="text-3xl font-bold text-gray-900">Trip Analysis Report</h1>
        <p class="text-gray-600 mt-2">Detailed traffic analysis for Trip #{{ $trip->id }}</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Trip Information</h2>
            <dl class="space-y-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Route</dt>
                    <dd class="text-lg text-gray-900">{{ $trip->start_location }} → {{ $trip->end_location }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Distance</dt>
                    <dd class="text-lg text-gray-900">{{ number_format($trip->distance ?? 0, 2) }} km</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Start Time</dt>
                    <dd class="text-lg text-gray-900">{{ $trip->start_time->format('M d, Y H:i') }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">End Time</dt>
                    <dd class="text-lg text-gray-900">{{ $trip->end_time?->format('M d, Y H:i') ?? 'In Progress' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                    <dd>
                        <span class="px-3 py-1 inline-block rounded-full text-xs font-medium
                            @if($trip->status === 'completed') bg-green-100 text-green-800
                            @elseif($trip->status === 'in_progress') bg-blue-100 text-blue-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst($trip->status) }}
                        </span>
                    </dd>
                </div>
            </dl>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Traffic Analysis Summary</h2>
            <dl class="space-y-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Average Speed</dt>
                    <dd class="text-lg text-gray-900">{{ number_format($analysis->average_speed, 1) }} km/h</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Max Speed / Min Speed</dt>
                    <dd class="text-lg text-gray-900">{{ number_format($analysis->max_speed, 1) }} / {{ number_format($analysis->min_speed, 1) }} km/h</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Estimated vs Actual Time</dt>
                    <dd class="text-lg @if($analysis->actual_time > $analysis->estimated_time) text-red-600 @else text-green-600 @endif">
                        {{ $analysis->estimated_time }} min / {{ $analysis->actual_time }} min
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Time Deviation</dt>
                    <dd class="text-lg @if($analysis->actual_time > $analysis->estimated_time) text-red-600 @else text-green-600 @endif font-medium">
                        @if($analysis->actual_time > $analysis->estimated_time)
                            <span>+{{ $analysis->actual_time - $analysis->estimated_time }} min (Slower)</span>
                        @else
                            <span>-{{ $analysis->estimated_time - $analysis->actual_time }} min (Faster)</span>
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Congestion Segments</dt>
                    <dd class="text-lg text-gray-900">{{ count($analysis->congestion_segments ?? []) }}</dd>
                </div>
            </dl>
        </div>
    </div>

    @if(count($analysis->congestion_segments ?? []) > 0)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-8 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Congestion Segments Detected</h2>
            </div>
            <div class="divide-y">
                @foreach($analysis->congestion_segments as $index => $segment)
                    <div class="px-6 py-4">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="font-medium text-gray-900">Segment {{ $index + 1 }}</h3>
                            <span class="text-sm text-gray-600">Duration: {{ $segment['duration_minutes'] }} min</span>
                        </div>
                        <div class="grid grid-cols-3 gap-4 text-sm">
                            <div>
                                <span class="text-gray-500">Time Range</span>
                                <p class="text-gray-900">{{ $segment['start_time']->format('H:i') }} - {{ $segment['end_time']->format('H:i') }}</p>
                            </div>
                            <div>
                                <span class="text-gray-500">Location</span>
                                <p class="text-gray-900">Lat: {{ number_format($segment['start_location'][0], 4) }}, Lng: {{ number_format($segment['start_location'][1], 4) }}</p>
                            </div>
                            <div>
                                <span class="text-gray-500">Speed at Congestion</span>
                                <p class="text-gray-900 font-medium text-orange-600">{{ number_format($segment['average_speed'], 1) }} km/h</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @if(count($recommendations) > 0)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Recommended Alternative Routes</h2>
            </div>
            <div class="divide-y">
                @foreach($recommendations as $recommendation)
                    <div class="px-6 py-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="font-semibold text-gray-900">{{ $recommendation->alternative_route }}</h3>
                                <p class="text-sm text-gray-600 mt-1">{{ $recommendation->status ?? 'Pending' }}</p>
                            </div>
                            <div class="text-right">
                                <div class="text-2xl font-bold text-green-600">{{ number_format($recommendation->estimated_time_saved, 0) }} min</div>
                                <p class="text-xs text-gray-500">Estimated time saved</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-4 gap-4 mb-4 text-sm">
                            <div class="bg-gray-50 p-3 rounded">
                                <span class="text-gray-600">Distance</span>
                                <p class="font-medium text-gray-900">{{ number_format($recommendation->distance, 2) }} km</p>
                            </div>
                            <div class="bg-gray-50 p-3 rounded">
                                <span class="text-gray-600">Confidence</span>
                                <p class="font-medium text-gray-900">{{ number_format($recommendation->confidence_level, 0) }}%</p>
                            </div>
                            <div class="bg-gray-50 p-3 rounded">
                                <span class="text-gray-600">Status</span>
                                <p class="font-medium text-gray-900 capitalize">{{ $recommendation->status }}</p>
                            </div>
                            <div class="bg-gray-50 p-3 rounded">
                                <span class="text-gray-600">Accepted</span>
                                <p class="font-medium">
                                    @if($recommendation->accepted_by_driver)
                                        <span class="text-green-600">✓ Yes</span>
                                    @else
                                        <span class="text-gray-400">✗ No</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        @if($recommendation->accepted_by_driver && $recommendation->actual_time_saved)
                            <div class="bg-green-50 border border-green-200 p-3 rounded">
                                <p class="text-sm text-green-800">
                                    <strong>Actual Result:</strong> {{ number_format($recommendation->actual_time_saved, 1) }} minutes were saved using this route!
                                </p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
            <p class="text-blue-800">No traffic congestion was detected on this route. Alternative routes are not recommended.</p>
        </div>
    @endif
</div>
</div>
@endsection
