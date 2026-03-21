<?php

namespace App\Services;

use App\Models\TrafficData;
use App\Models\RouteAnalysis;
use App\Models\RouteRecommendation;
use App\Models\Trip;
use Illuminate\Support\Collection;

class TrafficAnalysisService
{
    const CONGESTION_THRESHOLD_HIGH = 40;
    const CONGESTION_THRESHOLD_MODERATE = 60;
    const ANALYSIS_WINDOW = 15; 

  
    public function recordTrafficData(
        int $vehicleId,
        ?int $tripId,
        float $latitude,
        float $longitude,
        float $speed,
        ?int $heading = null
    ): TrafficData {
        $congestionLevel = $this->calculateCongestionLevel($speed);

        return TrafficData::create([
            'vehicle_id' => $vehicleId,
            'trip_id' => $tripId,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'speed' => $speed,
            'heading' => $heading,
            'timestamp' => now(),
            'congestion_level' => $congestionLevel,
        ]);
    }

    
    public function analyzeTripRoute(Trip $trip): RouteAnalysis
    {
       
        $trafficDataPoints = $trip->trafficData()
            ->orderBy('timestamp')
            ->get();

        if ($trafficDataPoints->isEmpty()) {
            return $this->createDefaultAnalysis($trip);
        }

        $speeds = $trafficDataPoints->pluck('speed')->toArray();
        $averageSpeed = array_sum($speeds) / count($speeds);
        $maxSpeed = max($speeds);
        $minSpeed = min($speeds);

        $congestionSegments = $this->identifyCongestionSegments($trafficDataPoints);

        $firstTimestamp = $trafficDataPoints->first()->timestamp;
        $lastTimestamp = $trafficDataPoints->last()->timestamp;
        $actualTime = $firstTimestamp->diffInMinutes($lastTimestamp);
        $estimatedTime = $this->estimateNormalTravelTime($trip->distance ?? 0, $averageSpeed);

        $analysis = RouteAnalysis::create([
            'trip_id' => $trip->id,
            'original_route' => $trip->start_location . ' to ' . $trip->end_location,
            'average_speed' => $averageSpeed,
            'max_speed' => $maxSpeed,
            'min_speed' => $minSpeed,
            'total_distance' => $trip->distance ?? 0,
            'estimated_time' => $estimatedTime,
            'actual_time' => $actualTime,
            'congestion_segments' => $congestionSegments,
            'analysis_date' => now(),
        ]);

        if (!empty($congestionSegments)) {
            $this->generateRouteRecommendations($analysis, $trip, $congestionSegments);
        }

        return $analysis;
    }


    protected function generateRouteRecommendations(
        RouteAnalysis $analysis,
        Trip $trip,
        array $congestionSegments
    ): void {
        $numberOfSegments = count($congestionSegments);
        
        for ($i = 1; $i <= min(3, $numberOfSegments); $i++) {
            $timeSaved = $this->estimateTimeSavings($analysis, $i);
            $confidence = max(60, min(95, 75 + ($i * 5)));

            RouteRecommendation::create([
                'route_analysis_id' => $analysis->id,
                'trip_id' => $trip->id,
                'alternative_route' => $this->generateAlternativeRoute($analysis, $i),
                'estimated_time_saved' => $timeSaved,
                'distance' => $trip->distance ?? 0,
                'confidence_level' => $confidence,
                'status' => 'pending',
            ]);
        }
    }

    protected function identifyCongestionSegments(Collection $trafficDataPoints): array
    {
        $segments = [];
        $inCongestion = false;
        $segmentStart = null;
        $segmentStartData = null;

        foreach ($trafficDataPoints as $data) {
            $isCongested = $data->speed < self::CONGESTION_THRESHOLD_HIGH;

            if ($isCongested && !$inCongestion) {
                $inCongestion = true;
                $segmentStart = $data->timestamp;
                $segmentStartData = $data;
            } elseif (!$isCongested && $inCongestion) {
                $inCongestion = false;
                if ($segmentStart) {
                    $segments[] = [
                        'start_time' => $segmentStart,
                        'end_time' => $data->timestamp,
                        'start_location' => [$segmentStartData->latitude, $segmentStartData->longitude],
                        'duration_minutes' => $segmentStart->diffInMinutes($data->timestamp),
                        'average_speed' => $segmentStartData->speed,
                    ];
                }
                $segmentStart = null;
                $segmentStartData = null;
            }
        }

        if ($inCongestion && $segmentStart) {
            $segments[] = [
                'start_time' => $segmentStart,
                'end_time' => $trafficDataPoints->last()->timestamp,
                'start_location' => [$segmentStartData->latitude, $segmentStartData->longitude],
                'duration_minutes' => $segmentStart->diffInMinutes($trafficDataPoints->last()->timestamp),
                'average_speed' => $segmentStartData->speed,
            ];
        }

        return $segments;
    }


    protected function calculateCongestionLevel(float $speed): string
    {
        if ($speed < self::CONGESTION_THRESHOLD_HIGH) {
            return 'severe';
        } elseif ($speed < self::CONGESTION_THRESHOLD_MODERATE) {
            return 'high';
        } elseif ($speed < self::CONGESTION_THRESHOLD_MODERATE + 20) {
            return 'moderate';
        }
        return 'low';
    }

  
    protected function estimateNormalTravelTime(float $distance, float $averageSpeed): int
    {
        if ($averageSpeed <= 0) {
            return 0;
        }
        return (int) ceil(($distance / $averageSpeed) * 60);
    }


    protected function estimateTimeSavings(RouteAnalysis $analysis, int $alternativeIndex): float
    {
        $congestionCount = count($analysis->congestion_segments ?? []);
        $savings = ($analysis->actual_time - $analysis->estimated_time) * (0.6 + ($alternativeIndex * 0.1));
        return max(0, $savings);
    }

 
    protected function generateAlternativeRoute(RouteAnalysis $analysis, int $index): string
    {
        $routes = [
            'Suggested alternate route via secondary highways to avoid main road congestion',
            'Bypass congested area using side roads and residential routes',
            'Alternative route with potential traffic flow improvements at different time',
        ];

        return $routes[$index - 1] ?? $routes[0];
    }

   
    protected function createDefaultAnalysis(Trip $trip): RouteAnalysis
    {
        return RouteAnalysis::create([
            'trip_id' => $trip->id,
            'original_route' => $trip->start_location . ' to ' . $trip->end_location,
            'average_speed' => 0,
            'max_speed' => 0,
            'min_speed' => 0,
            'total_distance' => $trip->distance ?? 0,
            'estimated_time' => 0,
            'actual_time' => null,
            'congestion_segments' => [],
            'analysis_date' => now(),
        ]);
    }

    public function getActiveTrafficStatus(): array
{
    $activeTrips = Trip::whereIn('status', ['in_progress', 'pending'])
        ->with(['trafficData' => function($query) {
            $query->latest('timestamp')->limit(1);
        }, 'vehicle'])
        ->get();

    $trafficStatus = [];
    foreach ($activeTrips as $trip) {
        $latestData = $trip->trafficData->first();

        $trafficStatus[] = [
            'trip_id'          => $trip->id,
            'vehicle_id'       => $trip->vehicle_id,
            'route'            => $trip->start_location . ' → ' . $trip->end_location,
            'current_speed'    => $latestData?->speed ?? 0,
            'congestion_level' => $latestData?->congestion_level ?? 'low',
            'location'         => [
                'latitude'  => $latestData?->latitude ?? 0,
                'longitude' => $latestData?->longitude ?? 0,
            ],
            'timestamp'        => $latestData?->timestamp ?? $trip->updated_at,
        ];
    }

    return $trafficStatus;
}

   
    public function getTripRecommendations(Trip $trip): Collection
    {
        return RouteRecommendation::where('trip_id', $trip->id)
            ->orderByDesc('confidence_level')
            ->get();
    }
}
