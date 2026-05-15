<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\TrafficData;
use App\Models\RouteAnalysis;
use App\Models\RouteRecommendation;
use App\Services\GeminiService;
use App\Services\TrafficAnalysisService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TrafficController extends Controller
{
    protected TrafficAnalysisService $trafficService;

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

    public function getVehicleTrafficHistory(int $vehicleId)
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

    public function getHotspotData(float $latitude, float $longitude)
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
                    "- Location ({$h->latitude}, {$h->longitude}): {$h->incident_count} incidents, avg speed " . number_format($h->avg_speed, 1) . " km/h, level: {$h->congestion_level}"
                  )->implode("\n");

            $currentStatus = $latestTraffic
                ? "Current speed: {$latestTraffic->speed} km/h, Congestion: {$latestTraffic->congestion_level}"
                : "No live GPS data available for this trip.";

            $vehicle = $trip->vehicle;
            $vehicleInfo = $vehicle
                ? "{$vehicle->plate_number} ({$vehicle->make} {$vehicle->model}, {$vehicle->type})"
                : "Fleet vehicle";

            // ── System prompt ─────────────────────────────────────────────
            $systemPrompt = "You are a fleet route optimization assistant. "
                . "You MUST respond with ONLY a valid JSON object — no markdown, no code blocks, no backticks, no explanation text. "
                . "Your entire response must be parseable by json_decode(). "
                . "Do NOT wrap the JSON in ```json or ``` tags. "
                . "Return ONLY the JSON object, nothing else.";

            // ── User prompt with exact required field names ────────────────
            $userPrompt = "Suggest an optimized route for this trip:\n"
                . "- From: {$trip->start_location}\n"
                . "- To: {$trip->end_location}\n"
                . "- Vehicle: {$vehicleInfo}\n"
                . "- Vehicle status: {$currentStatus}\n\n"
                . "CURRENT CONGESTION HOTSPOTS (last 2 hours):\n"
                . $hotspotSummary . "\n\n"
                . "You MUST respond with ONLY this exact JSON structure, no extra fields, no markdown:\n"
                . "{\n"
                . '    "suggested_route": "full step-by-step route description under 200 chars",' . "\n"
                . '    "estimated_time_saved": 15,' . "\n"
                . '    "confidence": 87,' . "\n"
                . '    "reason": "one to two sentences explaining the route choice",' . "\n"
                . '    "estimated_distance": "X.X km",' . "\n"
                . '    "estimated_duration": "X hours Y minutes",' . "\n"
                . '    "fuel_estimate": "approximately X liters",' . "\n"
                . '    "hotspots_avoided": ["hotspot description"]' . "\n"
                . "}\n\n"
                . "Rules:\n"
                . "- suggested_route: descriptive string with actual street directions\n"
                . "- estimated_time_saved: integer in MINUTES only, no text, no ~ symbol\n"
                . "- confidence: integer between 70 and 99, no % symbol\n"
                . "- reason: one to two sentences max\n"
                . "- hotspots_avoided: empty array [] if no hotspots exist\n"
                . "- All strings under 200 characters";

            // ── Call Gemini ───────────────────────────────────────────────
            $gemini   = new GeminiService();
            $contents = $gemini->buildSingleTurn($userPrompt);
            $aiText   = $gemini->generate($systemPrompt, $contents, 2048, 0.4);

            if ($aiText === null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gemini AI service unavailable. Please try again.',
                ], 500);
            }

            // ── Parse JSON with retry ─────────────────────────────────────
            $parsed = $this->parseRouteResponse($aiText);

            if (!$parsed) {
                $simplePrompt  = "Route from {$trip->start_location} to {$trip->end_location}. "
                    . "Reply ONLY with valid JSON: "
                    . '{"suggested_route":"Take main highway route","estimated_time_saved":10,"confidence":80,"reason":"Direct route with minimal traffic.","estimated_distance":"N/A","estimated_duration":"N/A","fuel_estimate":"N/A","hotspots_avoided":[]}';
                $retryContents = [['role' => 'user', 'parts' => [['text' => $simplePrompt]]]];
                $retryText     = $gemini->generate($systemPrompt, $retryContents, 512, 0.3);
                $parsed        = $retryText ? $this->parseRouteResponse($retryText) : null;
            }

            if (!$parsed) {
                Log::error('Gemini route suggestion: both parse attempts failed', [
                    'trip_id'     => $trip->id,
                    'raw_preview' => substr($aiText ?? '', 0, 300),
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Could not generate route suggestion. Please try again.',
                ], 422);
            }

            // ── Normalise ALL possible field name variants ────────────────
            // This ensures the frontend always receives a stable field contract
            // regardless of what exact names Gemini chose to use.
            $suggestedRoute = $parsed['suggested_route']
                ?? $parsed['recommended_route']
                ?? $parsed['alternative_route']
                ?? $parsed['route_description']
                ?? $parsed['main_route']
                ?? $parsed['route']
                ?? 'Route optimized for current conditions.';

            $timeSaved = (int) ($parsed['estimated_time_saved']
                ?? $parsed['time_saved']
                ?? $parsed['time']
                ?? 0);
            // Handle string values like "15 minutes" or "~15 mins"
            if ($timeSaved === 0 && isset($parsed['estimated_time_saved'])) {
                preg_match('/\d+/', (string) $parsed['estimated_time_saved'], $m);
                $timeSaved = isset($m[0]) ? (int) $m[0] : 0;
            }

            $confidence = (int) ($parsed['confidence'] ?? 85);
            // Strip % symbol if Gemini included it
            if ($confidence === 0 && isset($parsed['confidence'])) {
                preg_match('/\d+/', (string) $parsed['confidence'], $m);
                $confidence = isset($m[0]) ? (int) $m[0] : 85;
            }
            $confidence = max(70, min(99, $confidence));

            $reason = $parsed['reason']
                ?? $parsed['why']
                ?? $parsed['explanation']
                ?? 'Route optimized for current traffic conditions and efficiency.';

            return response()->json([
                'success'               => true,
                // Primary display fields (stable names the frontend uses)
                'suggested_route'       => $suggestedRoute,
                'estimated_time_saved'  => $timeSaved,
                'confidence'            => $confidence,
                'reason'                => $reason,
                // Extra detail fields
                'estimated_distance'    => $parsed['estimated_distance'] ?? 'N/A',
                'estimated_duration'    => $parsed['estimated_duration'] ?? 'N/A',
                'fuel_estimate'         => $parsed['fuel_estimate']      ?? 'N/A',
                'hotspots_avoided'      => $parsed['hotspots_avoided']   ?? [],
                // Route coordinates for map rendering (start/end names)
                'from'                  => $trip->start_location,
                'to'                    => $trip->end_location,
            ]);

        } catch (\Exception $e) {
            Log::error('suggestRoute exception', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred. Please try again.',
            ], 500);
        }
    }

    /**
     * Robustly parse a JSON string from Gemini.
     * Handles markdown fences, surrounding text, and truncated responses.
     */
    private function parseRouteResponse(string $raw): ?array
    {
        // 1. Strip markdown code fences
        $cleaned = preg_replace('/```json\s*/i', '', $raw);
        $cleaned = preg_replace('/```\s*/i',     '', $cleaned);
        $cleaned = trim($cleaned);

        // 2. Extract the first JSON object if there is surrounding text
        if (preg_match('/\{.*\}/s', $cleaned, $matches)) {
            $cleaned = $matches[0];
        }

        // 3. Fast path: direct decode
        $decoded = json_decode($cleaned, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $decoded;
        }

        // 4. Repair truncated JSON and retry
        $repaired = $this->fixTruncatedJson($cleaned);
        $decoded  = json_decode($repaired, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error('Route suggestion JSON parse failed', [
                'error'       => json_last_error_msg(),
                'raw_preview' => substr($raw, 0, 500),
            ]);
            return null;
        }

        return is_array($decoded) ? $decoded : null;
    }

    /**
     * Close unclosed braces/brackets in a truncated JSON string.
     */
    private function fixTruncatedJson(string $json): string
    {
        $openBraces   = substr_count($json, '{') - substr_count($json, '}');
        $openBrackets = substr_count($json, '[') - substr_count($json, ']');

        // If the string appears to end mid-value, close the string
        $lastChar = substr(rtrim($json), -1);
        if ($lastChar !== '"' && $lastChar !== '}' && $lastChar !== ']' && $lastChar !== ',') {
            $json .= '"';
        }

        // Close open arrays first, then objects
        $json .= str_repeat(']', max(0, $openBrackets));
        $json .= str_repeat('}', max(0, $openBraces));

        return $json;
    }
}