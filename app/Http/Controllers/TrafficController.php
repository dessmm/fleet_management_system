<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\TrafficData;
use App\Models\RouteAnalysis;
use App\Models\RouteRecommendation;
use App\Services\TrafficAnalysisService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TrafficController extends Controller
{
    protected $trafficService;

    public function __construct(TrafficAnalysisService $trafficService)
    {
        $this->trafficService = $trafficService;
    }

    public function dashboard()
    {
        $activeTraffic = $this->trafficService->getActiveTrafficStatus();
        $recentAnalysis = RouteAnalysis::with('trip')->latest('analysis_date')->limit(5)->get();
        $congestionCount = TrafficData::where('congestion_level', '!=', 'low')
            ->where('timestamp', '>=', now()->subHours(1))->count();
        return view('traffic.dashboard', compact('activeTraffic', 'recentAnalysis', 'congestionCount'));
    }

    public function recordData(Request $request)
    {
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'trip_id' => 'nullable|exists:trips,id',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'speed' => 'required|numeric|min:0',
            'heading' => 'nullable|integer|between:0,360',
        ]);
        $trafficData = $this->trafficService->recordTrafficData(
            $validated['vehicle_id'], $validated['trip_id'] ?? null,
            $validated['latitude'], $validated['longitude'],
            $validated['speed'], $validated['heading'] ?? null
        );
        return response()->json(['success' => true, 'message' => 'Traffic data recorded successfully', 'data' => $trafficData]);
    }

    public function getActiveStatus()
    {
        $status = $this->trafficService->getActiveTrafficStatus();
        return response()->json(['success' => true, 'data' => $status, 'timestamp' => now()]);
    }

    public function analyzeTrip(Trip $trip)
    {
        if ($trip->status !== 'completed') {
            return response()->json(['success' => false, 'message' => 'Only completed trips can be analyzed'], 400);
        }
        $analysis = $this->trafficService->analyzeTripRoute($trip);
        return response()->json(['success' => true, 'message' => 'Trip analysis completed', 'analysis' => $analysis->load('routeRecommendations')]);
    }

    public function showAnalysis(Trip $trip)
    {
        $analysis = $trip->routeAnalysis;
        $recommendations = $trip->routeRecommendations;
        if (!$analysis) {
            return redirect()->back()->with('error', 'No analysis available for this trip');
        }
        return view('traffic.trip_analysis', compact('trip', 'analysis', 'recommendations'));
    }

    public function getRecommendations(Trip $trip)
    {
        $recommendations = $this->trafficService->getTripRecommendations($trip);
        return response()->json(['success' => true, 'data' => $recommendations]);
    }

    public function updateRecommendationStatus(RouteRecommendation $recommendation, Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,sent,accepted,rejected,in_progress,completed',
            'accepted_by_driver' => 'boolean',
            'actual_time_saved' => 'nullable|numeric',
        ]);
        $recommendation->update($validated);
        return response()->json(['success' => true, 'message' => 'Recommendation status updated', 'data' => $recommendation]);
    }

    public function getVehicleTrafficHistory($vehicleId)
    {
        $trafficData = TrafficData::where('vehicle_id', $vehicleId)
            ->where('timestamp', '>=', now()->subDays(7))
            ->orderByDesc('timestamp')->paginate(50);
        return response()->json(['success' => true, 'data' => $trafficData]);
    }

    public function getCongestionHotspots()
    {
        $hotspots = TrafficData::where('congestion_level', '!=', 'low')
            ->where('timestamp', '>=', now()->subHours(2))
            ->selectRaw('latitude, longitude, COUNT(*) as incident_count, AVG(speed) as avg_speed, congestion_level')
            ->groupBy('latitude', 'longitude', 'congestion_level')
            ->having('incident_count', '>', 2)->get();
        return response()->json(['success' => true, 'data' => $hotspots]);
    }

    public function showHotspots()
    {
        $hotspots = TrafficData::where('congestion_level', '!=', 'low')
            ->where('timestamp', '>=', now()->subHours(2))
            ->selectRaw('latitude, longitude, COUNT(*) as incident_count, AVG(speed) as avg_speed, congestion_level')
            ->groupBy('latitude', 'longitude', 'congestion_level')
            ->having('incident_count', '>', 2)->get();
        return view('traffic.hotspots', compact('hotspots'));
    }

    public function getHotspotData($latitude, $longitude)
    {
        $hotspotData = TrafficData::where('congestion_level', '!=', 'low')
            ->where('timestamp', '>=', now()->subHours(2))
            ->where('latitude', $latitude)->where('longitude', $longitude)
            ->orderBy('timestamp', 'desc')->get();
        if ($hotspotData->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'No data found for this hotspot'], 404);
        }
        return response()->json([
            'success' => true,
            'data' => [
                'location' => ['latitude' => $latitude, 'longitude' => $longitude],
                'summary' => [
                    'incident_count' => count($hotspotData),
                    'avg_speed' => $hotspotData->avg('speed'),
                    'congestion_levels' => $hotspotData->groupBy('congestion_level')->map->count(),
                ],
                'records' => $hotspotData,
            ],
        ]);
    }

    public function analytics()
    {
        // ── Existing stats ────────────────────────────────────────
    $totalTripsAnalyzed = RouteAnalysis::count();
 
    $avgCongestionSavings = RouteRecommendation::whereNotNull('actual_time_saved')
        ->avg('actual_time_saved') ?? 0;
 
    $acceptanceRate = RouteRecommendation::count() > 0
        ? (RouteRecommendation::where('accepted_by_driver', true)->count() /
           RouteRecommendation::count() * 100)
        : 0;
 
    $congestionByDay = TrafficData::selectRaw('DATE(timestamp) as date, congestion_level, COUNT(*) as count')
        ->where('timestamp', '>=', now()->subDays(30))
        ->groupBy('date', 'congestion_level')
        ->get();
 
    // ── Real Fleet Performance stats ──────────────────────────
    $completedTrips = Trip::where('status', 'completed')
        ->whereNotNull('start_time')
        ->whereNotNull('end_time')
        ->get();
 
    // Average trip duration in minutes
    $avgTripDuration = $completedTrips->avg(function ($trip) {
        return $trip->start_time->diffInMinutes($trip->end_time);
    }) ?? 0;
 
    // Average distance per trip
    $avgDistance = Trip::where('status', 'completed')
        ->whereNotNull('distance')
        ->avg('distance') ?? 0;
 
    // Fleet average speed from TrafficData
    $fleetAvgSpeed = TrafficData::avg('speed') ?? 0;
 
    // On-time arrivals: trips where actual_time <= estimated_time
    $totalAnalyzed  = RouteAnalysis::count();
    $onTimeCount    = RouteAnalysis::whereRaw('actual_time <= estimated_time')->count();
    $onTimeRate     = $totalAnalyzed > 0 ? ($onTimeCount / $totalAnalyzed * 100) : 0;
 
    // ── Real Route Optimization stats ────────────────────────
    $totalRecommendations = RouteRecommendation::count();
    $acceptedRoutes       = RouteRecommendation::where('accepted_by_driver', true)->count();
 
    $avgEfficiencyGain = RouteAnalysis::whereRaw('estimated_time > 0')
        ->selectRaw('AVG((estimated_time - actual_time) / estimated_time * 100) as efficiency')
        ->value('efficiency') ?? 0;
 
    // ── Real Cost Savings stats ───────────────────────────────
    // Total minutes saved across all accepted recommendations
    $totalMinutesSaved = RouteRecommendation::where('accepted_by_driver', true)
        ->whereNotNull('actual_time_saved')
        ->sum('actual_time_saved');
 
    $totalHoursSaved = $totalMinutesSaved / 60;
 
    // Fuel saved estimate: assume 0.5L per minute of congestion avoided
    $fuelSaved = $totalMinutesSaved * 0.5;
 
    // Cost reduction estimate: assume $1.20 per liter (PHP ~70/L)
    $costReduction = $fuelSaved * 1.20;
 
    // ROI: if each recommendation costs ~$0.01 (API cost), ROI = savings / cost * 100
    $investmentCost = max(1, $totalRecommendations * 0.01);
    $roi = ($costReduction / $investmentCost) * 100;
 
    // ── 30 day summary stats ──────────────────────────────────
    $tripsLast30     = Trip::where('status', 'completed')
        ->where('updated_at', '>=', now()->subDays(30))
        ->count();
 
    $avgCongestionPerDay = TrafficData::where('congestion_level', '!=', 'low')
        ->where('timestamp', '>=', now()->subDays(30))
        ->selectRaw('DATE(timestamp) as date, COUNT(*) as count')
        ->groupBy('date')
        ->get()
        ->avg('count') ?? 0;
 
    $altRoutesUsed = RouteRecommendation::where('accepted_by_driver', true)
        ->where('created_at', '>=', now()->subDays(30))
        ->count();
 
    $timeSavedHours30 = RouteRecommendation::where('accepted_by_driver', true)
        ->whereNotNull('actual_time_saved')
        ->where('created_at', '>=', now()->subDays(30))
        ->sum('actual_time_saved') / 60;
 
    return view('traffic.analytics', compact(
        'totalTripsAnalyzed',
        'avgCongestionSavings',
        'acceptanceRate',
        'congestionByDay',
        // Fleet performance
        'avgTripDuration',
        'avgDistance',
        'fleetAvgSpeed',
        'onTimeRate',
        // Route optimization
        'totalRecommendations',
        'acceptedRoutes',
        'avgEfficiencyGain',
        // Cost savings
        'fuelSaved',
        'costReduction',
        'totalHoursSaved',
        'roi',
        // 30 day summary
        'tripsLast30',
        'avgCongestionPerDay',
        'altRoutesUsed',
        'timeSavedHours30'
    ));
    }

    /**
     * AI-powered route suggestion based on current hotspots
     */
    public function suggestRoute(Trip $trip)
    {
        try {
            $hotspots = TrafficData::where('congestion_level', '!=', 'low')
                ->where('timestamp', '>=', now()->subHours(2))
                ->selectRaw('latitude, longitude, COUNT(*) as incident_count, AVG(speed) as avg_speed, congestion_level')
                ->groupBy('latitude', 'longitude', 'congestion_level')
                ->having('incident_count', '>', 2)
                ->get();

            $latestTraffic = $trip->trafficData()->latest('timestamp')->first();

            $hotspotSummary = $hotspots->isEmpty()
                ? 'No major congestion hotspots detected currently.'
                : $hotspots->map(fn($h) =>
                    "- Location ({$h->latitude}, {$h->longitude}): {$h->incident_count} incidents, avg speed {$h->avg_speed} km/h, level: {$h->congestion_level}"
                  )->implode("\n");

            $currentStatus = $latestTraffic
                ? "Current speed: {$latestTraffic->speed} km/h, Congestion: {$latestTraffic->congestion_level}"
                : "No live GPS data available for this trip.";

            $prompt = "You are a fleet traffic analyst. A vehicle is on a trip and you must suggest an alternative route to avoid congestion.\n\n"
                . "TRIP DETAILS:\n"
                . "- From: " . $trip->start_location . "\n"
                . "- To: " . $trip->end_location . "\n"
                . "- Distance: " . $trip->distance . " km\n"
                . "- Status: " . $trip->status . "\n"
                . "- " . $currentStatus . "\n\n"
                . "CURRENT CONGESTION HOTSPOTS (last 2 hours):\n"
                . $hotspotSummary . "\n\n"
                . "Based on this data, respond ONLY with a valid JSON object (no markdown, no explanation outside the JSON) with exactly these fields:\n"
                . "{\n"
                . '  "alternative_route": "Clear description of the suggested alternative route",' . "\n"
                . '  "reason": "Brief explanation of why this route avoids congestion (2-3 sentences)",' . "\n"
                . '  "time_saved": "Estimated time saved (e.g. ~15 mins)",' . "\n"
                . '  "confidence": "Confidence percentage (e.g. 82%)",' . "\n"
                . '  "hotspots_avoided": ["description of hotspot avoided"]' . "\n"
                . "}\n\n"
                . "If there are no hotspots, still suggest the most efficient route and set hotspots_avoided to an empty array.";

            $response = Http::withOptions(['verify' => false])
                ->withHeaders([
                    'x-api-key'         => config('services.anthropic.key'),
                    'anthropic-version' => '2023-06-01',
                    'content-type'      => 'application/json',
                ])
                ->post('https://api.anthropic.com/v1/messages', [
                    'model'      => 'claude-sonnet-4-5',
                    'max_tokens' => 800,
                    'messages'   => [
                        ['role' => 'user', 'content' => $prompt],
                    ],
                ]);

            if (!$response->successful()) {
                Log::error('Anthropic API error', ['status' => $response->status(), 'body' => $response->body()]);
                return response()->json([
                    'success' => false,
                    'message' => 'API Error ' . $response->status() . ': ' . $response->body(),
                ], 500);
            }

            $content = $response->json('content.0.text', '');
            $content = preg_replace('/```json|```/i', '', $content);
            $content = trim($content);
            $result = json_decode($content, true);

            if (!$result || !isset($result['alternative_route'])) {
                Log::error('Anthropic parse error', ['content' => $content]);
                return response()->json([
                    'success' => false,
                    'message' => 'Could not parse AI response: ' . $content,
                ], 500);
            }

            return response()->json([
                'success'           => true,
                'alternative_route' => $result['alternative_route'],
                'reason'            => $result['reason'],
                'time_saved'        => $result['time_saved'],
                'confidence'        => $result['confidence'],
                'hotspots_avoided'  => $result['hotspots_avoided'] ?? [],
            ]);

        } catch (\Exception $e) {
            Log::error('suggestRoute exception', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}