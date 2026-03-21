@extends('app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-amber-50 to-slate-100 py-8">
<div class="max-w-7xl mx-auto px-4 md:px-8">
    <div class="mb-8">
        <a href="{{ route('traffic.dashboard') }}" class="text-amber-600 hover:text-amber-800 text-sm font-medium mb-4 inline-block">
            ← Back to Dashboard
        </a>
        <h1 class="text-3xl font-bold text-gray-900">Traffic Analytics</h1>
        <p class="text-gray-600 mt-2">Key metrics and insights from traffic management system</p>
    </div>

    {{-- Top KPI Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 border-l-4 border-amber-500">
            <div class="text-sm font-medium text-gray-500 mb-2">Total Trips Analyzed</div>
            <div class="text-4xl font-bold text-amber-600">{{ $totalTripsAnalyzed }}</div>
            <p class="text-xs text-gray-500 mt-2">All-time total</p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 border-l-4 border-green-500">
            <div class="text-sm font-medium text-gray-500 mb-2">Avg Time Saved</div>
            <div class="text-4xl font-bold text-green-600">{{ number_format($avgCongestionSavings, 1) }}</div>
            <p class="text-xs text-gray-500 mt-2">Minutes per accepted route</p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 border-l-4 border-purple-500">
            <div class="text-sm font-medium text-gray-500 mb-2">Route Recommendation Acceptance</div>
            <div class="text-4xl font-bold text-purple-600">{{ number_format($acceptanceRate, 1) }}%</div>
            <p class="text-xs text-gray-500 mt-2">Driver acceptance rate</p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 border-l-4 border-orange-500">
            <div class="text-sm font-medium text-gray-500 mb-2">Total Time Saved</div>
            <div class="text-4xl font-bold text-orange-600">{{ number_format($totalHoursSaved, 1) }}<span class="text-lg font-normal text-gray-400 ml-1">hrs</span></div>
            <p class="text-xs text-gray-500 mt-2">Cumulative hours saved</p>
        </div>
    </div>

    {{-- Charts --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Congestion Incidents Over Time</h2>
            @php
                $groupedByDate = collect($congestionByDay)->groupBy('date');
                $chartDates    = $groupedByDate->keys()->toArray();
                $chartLow = $chartModerate = $chartHigh = $chartSevere = [];
                foreach ($groupedByDate as $date => $items) {
                    $chartLow[]      = $items->where('congestion_level', 'low')->sum('count');
                    $chartModerate[] = $items->where('congestion_level', 'moderate')->sum('count');
                    $chartHigh[]     = $items->where('congestion_level', 'high')->sum('count');
                    $chartSevere[]   = $items->where('congestion_level', 'severe')->sum('count');
                }
            @endphp
            @if(count($chartDates) > 0)
                <div class="relative h-64"><canvas id="congestionTimeChart"></canvas></div>
            @else
                <div class="h-64 bg-gray-50 rounded-xl flex flex-col items-center justify-center text-gray-400">
                    <p class="text-sm">No congestion data for the past 30 days</p>
                </div>
            @endif
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Congestion Level Distribution</h2>
            @php
                $totalIncidents = collect($congestionByDay)->sum('count');
                $distLow      = collect($congestionByDay)->where('congestion_level', 'low')->sum('count');
                $distModerate = collect($congestionByDay)->where('congestion_level', 'moderate')->sum('count');
                $distHigh     = collect($congestionByDay)->where('congestion_level', 'high')->sum('count');
                $distSevere   = collect($congestionByDay)->where('congestion_level', 'severe')->sum('count');
            @endphp
            @if($totalIncidents > 0)
                <div class="flex items-center gap-6">
                    <div class="relative w-48 h-48 flex-shrink-0">
                        <canvas id="congestionDistChart"></canvas>
                    </div>
                    <div class="space-y-3 flex-1">
                        @foreach([['Low Traffic','low','bg-emerald-500','text-emerald-700',$distLow],['Moderate Traffic','moderate','bg-yellow-400','text-yellow-700',$distModerate],['High Traffic','high','bg-orange-500','text-orange-700',$distHigh],['Severe Traffic','severe','bg-red-500','text-red-700',$distSevere]] as [$lbl,,$clr,$txt,$val])
                            @php $pct = $totalIncidents > 0 ? ($val / $totalIncidents * 100) : 0; @endphp
                            <div class="flex items-center gap-3">
                                <div class="w-3 h-3 rounded-full {{ $clr }} flex-shrink-0"></div>
                                <span class="text-sm text-gray-600 flex-1">{{ $lbl }}</span>
                                <span class="text-sm font-semibold {{ $txt }}">{{ number_format($pct, 1) }}%</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="h-64 bg-gray-50 rounded-xl flex flex-col items-center justify-center text-gray-400">
                    <p class="text-sm">No distribution data available</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Real Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

        {{-- Fleet Performance --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center gap-2 mb-4">
                <div class="w-7 h-7 rounded-lg bg-blue-100 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-blue-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 17a2 2 0 104 0 2 2 0 00-4 0m8 0a2 2 0 104 0 2 2 0 00-4 0M3 7h2l2-4h10l2 4h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1V8a1 1 0 011-1z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900">Fleet Performance</h3>
            </div>
            <dl class="space-y-3">
                <div class="flex justify-between items-center py-1 border-b border-gray-50">
                    <dt class="text-sm text-gray-500">Avg Trip Duration</dt>
                    <dd class="font-semibold text-gray-900">{{ $avgTripDuration > 0 ? number_format($avgTripDuration, 0) . ' min' : '—' }}</dd>
                </div>
                <div class="flex justify-between items-center py-1 border-b border-gray-50">
                    <dt class="text-sm text-gray-500">Avg Distance/Trip</dt>
                    <dd class="font-semibold text-gray-900">{{ $avgDistance > 0 ? number_format($avgDistance, 1) . ' km' : '—' }}</dd>
                </div>
                <div class="flex justify-between items-center py-1 border-b border-gray-50">
                    <dt class="text-sm text-gray-500">Fleet Avg Speed</dt>
                    <dd class="font-semibold text-gray-900">{{ $fleetAvgSpeed > 0 ? number_format($fleetAvgSpeed, 1) . ' km/h' : '—' }}</dd>
                </div>
                <div class="flex justify-between items-center py-1">
                    <dt class="text-sm text-gray-500">On-time Arrivals</dt>
                    <dd class="font-semibold {{ $onTimeRate >= 80 ? 'text-green-600' : ($onTimeRate >= 60 ? 'text-amber-600' : 'text-red-600') }}">
                        {{ $totalTripsAnalyzed > 0 ? number_format($onTimeRate, 1) . '%' : '—' }}
                    </dd>
                </div>
            </dl>
        </div>

        {{-- Route Optimization --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center gap-2 mb-4">
                <div class="w-7 h-7 rounded-lg bg-purple-100 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-purple-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900">Route Optimization</h3>
            </div>
            <dl class="space-y-3">
                <div class="flex justify-between items-center py-1 border-b border-gray-50">
                    <dt class="text-sm text-gray-500">Recommendations Sent</dt>
                    <dd class="font-semibold text-gray-900">{{ number_format($totalRecommendations) }}</dd>
                </div>
                <div class="flex justify-between items-center py-1 border-b border-gray-50">
                    <dt class="text-sm text-gray-500">Routes Accepted</dt>
                    <dd class="font-semibold text-gray-900">{{ number_format($acceptedRoutes) }}</dd>
                </div>
                <div class="flex justify-between items-center py-1 border-b border-gray-50">
                    <dt class="text-sm text-gray-500">Avg Efficiency Gain</dt>
                    <dd class="font-semibold {{ $avgEfficiencyGain >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $totalTripsAnalyzed > 0 ? ($avgEfficiencyGain >= 0 ? '+' : '') . number_format($avgEfficiencyGain, 1) . '%' : '—' }}
                    </dd>
                </div>
                <div class="flex justify-between items-center py-1">
                    <dt class="text-sm text-gray-500">Success Rate</dt>
                    <dd class="font-semibold text-blue-600">{{ number_format($acceptanceRate, 1) }}%</dd>
                </div>
            </dl>
        </div>

        {{-- Cost Savings --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center gap-2 mb-4">
                <div class="w-7 h-7 rounded-lg bg-green-100 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-green-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900">Cost Savings</h3>
            </div>
            <dl class="space-y-3">
                <div class="flex justify-between items-center py-1 border-b border-gray-50">
                    <dt class="text-sm text-gray-500">Fuel Saved (Est.)</dt>
                    <dd class="font-semibold text-green-600">{{ $fuelSaved > 0 ? number_format($fuelSaved, 0) . ' L' : '—' }}</dd>
                </div>
                <div class="flex justify-between items-center py-1 border-b border-gray-50">
                    <dt class="text-sm text-gray-500">Cost Reduction</dt>
                    <dd class="font-semibold text-green-600">{{ $costReduction > 0 ? '$' . number_format($costReduction, 2) : '—' }}</dd>
                </div>
                <div class="flex justify-between items-center py-1 border-b border-gray-50">
                    <dt class="text-sm text-gray-500">Driver Hours Saved</dt>
                    <dd class="font-semibold text-green-600">{{ $totalHoursSaved > 0 ? number_format($totalHoursSaved, 1) . ' hrs' : '—' }}</dd>
                </div>
                <div class="flex justify-between items-center py-1">
                    <dt class="text-sm text-gray-500">ROI (Estimated)</dt>
                    <dd class="font-semibold text-green-600">{{ $roi > 0 ? number_format($roi, 0) . '%' : '—' }}</dd>
                </div>
            </dl>
        </div>
    </div>

    {{-- 30 Day Summary Table --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-900">Last 30 Days Summary</h2>
            <span class="text-xs text-gray-400 bg-gray-100 px-2 py-1 rounded-lg">Live data</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b">
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Metric</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Value</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-900">Total Trips Completed</td>
                        <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $tripsLast30 }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $tripsLast30 > 0 ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                {{ $tripsLast30 > 0 ? '✓ Active' : 'No trips' }}
                            </span>
                        </td>
                    </tr>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-900">Avg Congestion Incidents/Day</td>
                        <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ number_format($avgCongestionPerDay, 1) }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                {{ $avgCongestionPerDay == 0 ? 'bg-green-100 text-green-700' : ($avgCongestionPerDay < 5 ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                {{ $avgCongestionPerDay == 0 ? '✓ Clear' : ($avgCongestionPerDay < 5 ? '⚠ Moderate' : '⚠ High') }}
                            </span>
                        </td>
                    </tr>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-900">Alternative Routes Used</td>
                        <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $altRoutesUsed }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $altRoutesUsed > 0 ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-500' }}">
                                {{ $altRoutesUsed > 0 ? '✓ Optimizing' : 'None yet' }}
                            </span>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-900">Total Time Saved</td>
                        <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ number_format($timeSavedHours30, 1) }} hrs</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $timeSavedHours30 > 0 ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                {{ $timeSavedHours30 > 0 ? '✓ Saving time' : 'No savings yet' }}
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    // @ts-nocheck
    const timeCtx = document.getElementById('congestionTimeChart');
    if (timeCtx) {
        new Chart(timeCtx, {
            type: 'bar',
            data: {
                labels: @json($chartDates),
                datasets: [
                    { label: 'Low',      data: @json($chartLow),      backgroundColor: 'rgba(16,185,129,0.75)',  borderRadius: 3 },
                    { label: 'Moderate', data: @json($chartModerate), backgroundColor: 'rgba(251,191,36,0.75)',  borderRadius: 3 },
                    { label: 'High',     data: @json($chartHigh),     backgroundColor: 'rgba(249,115,22,0.75)',  borderRadius: 3 },
                    { label: 'Severe',   data: @json($chartSevere),   backgroundColor: 'rgba(239,68,68,0.75)',   borderRadius: 3 },
                ],
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom', labels: { font: { size: 11 }, boxWidth: 12, padding: 12 } },
                    tooltip: { mode: 'index', intersect: false },
                },
                scales: {
                    x: { stacked: true, grid: { display: false }, ticks: { font: { size: 11 } } },
                    y: { stacked: true, beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' }, ticks: { font: { size: 11 }, stepSize: 1 } },
                },
            },
        });
    }

    const distCtx = document.getElementById('congestionDistChart');
    if (distCtx) {
        new Chart(distCtx, {
            type: 'doughnut',
            data: {
                labels: ['Low', 'Moderate', 'High', 'Severe'],
                datasets: [{
                    data: [{{ $distLow }}, {{ $distModerate }}, {{ $distHigh }}, {{ $distSevere }}],
                    backgroundColor: ['rgba(16,185,129,0.85)','rgba(251,191,36,0.85)','rgba(249,115,22,0.85)','rgba(239,68,68,0.85)'],
                    borderWidth: 2, borderColor: '#fff', hoverOffset: 6,
                }],
            },
            options: {
                responsive: true, maintainAspectRatio: false, cutout: '68%',
                plugins: {
                    legend: { display: false },
                    tooltip: { callbacks: { label: ctx => ` ${ctx.label}: ${ctx.parsed} incident(s)` } },
                },
            },
        });
    }
</script>
@endsection