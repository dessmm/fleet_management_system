@if(count($activeTraffic) > 0)
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
            <tbody class="divide-y divide-gray-50">
                @foreach($activeTraffic as $traffic)
                    <tr class="traffic-row"
                        data-route="{{ strtolower($traffic['route']) }}"
                        data-congestion="{{ $traffic['congestion_level'] }}">
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 bg-amber-100 text-amber-700 text-xs font-semibold rounded-lg">#{{ $traffic['trip_id'] }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm font-medium text-gray-900">{{ $traffic['route'] }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-semibold text-gray-900">{{ number_format($traffic['current_speed'], 1) }}</span>
                            <span class="text-xs text-gray-400 ml-0.5">km/h</span>
                        </td>
                        <td class="px-6 py-4">
                            @php $level = $traffic['congestion_level']; @endphp
                            @if($level === 'severe')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-red-50 text-red-700 text-xs font-semibold rounded-full border border-red-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500 pulse"></span>Severe
                                </span>
                            @elseif($level === 'high')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-orange-50 text-orange-700 text-xs font-semibold rounded-full border border-orange-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-orange-500"></span>High
                                </span>
                            @elseif($level === 'moderate')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-yellow-50 text-yellow-700 text-xs font-semibold rounded-full border border-yellow-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span>Moderate
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-50 text-emerald-700 text-xs font-semibold rounded-full border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Low
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <a href="https://www.google.com/maps?q={{ $traffic['location']['latitude'] }},{{ $traffic['location']['longitude'] }}"
                               target="_blank"
                               class="inline-flex items-center gap-1 text-xs text-amber-600 hover:text-amber-800 font-mono hover:underline">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3.5 h-3.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                                </svg>
                                {{ number_format($traffic['location']['latitude'], 4) }}, {{ number_format($traffic['location']['longitude'], 4) }}
                            </a>
                        </td>
                        <td class="px-6 py-4 text-xs text-gray-500">{{ $traffic['timestamp']->diffForHumans() }}</td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('trips.show', $traffic['trip_id']) }}"
                               class="action-btn inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-amber-700 bg-amber-50 hover:bg-amber-100 border border-amber-200 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3.5 h-3.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                View Trip
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="flex flex-col items-center justify-center py-20 px-4 text-center">
        <div class="w-20 h-20 bg-amber-50 rounded-full flex items-center justify-center mb-5">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-amber-400">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 17a2 2 0 104 0 2 2 0 00-4 0m8 0a2 2 0 104 0 2 2 0 00-4 0M3 7h2l2-4h10l2 4h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1V8a1 1 0 011-1z"/>
            </svg>
        </div>
        <h3 class="text-lg font-semibold text-gray-700 mb-2">No active vehicles</h3>
        <p class="text-gray-400 text-sm max-w-xs">No vehicles are currently being tracked. Active trips will appear here in real time.</p>
    </div>
@endif