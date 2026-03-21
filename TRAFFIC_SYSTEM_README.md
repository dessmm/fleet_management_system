# Traffic Congestion Detection & Route Optimization System

## Overview
This system provides real-time vehicle data collection, traffic congestion analysis, and intelligent route recommendations to reduce travel time and improve fleet efficiency.

## Features

### 1. Real-Time Vehicle Tracking
- **Real-time GPS Data Collection**: Records vehicle location, speed, and heading
- **Congestion Level Detection**: Automatically categorizes traffic conditions (low, moderate, high, severe)
- **Active Vehicle Monitoring**: Dashboard showing all currently tracked vehicles

### 2. Traffic Analysis
- **Trip Route Analysis**: Analyzes completed trips to identify congestion patterns
- **Speed Pattern Recognition**: Identifies when and where traffic slows down
- **Congestion Segment Detection**: Automatically detects and logs traffic congestion areas
- **Time Variance Calculation**: Compares actual vs. estimated travel times

### 3. Route Optimization
- **Alternative Route Suggestions**: Generates up to 3 alternative routes per trip
- **Time Savings Estimation**: Predicts how much time can be saved with each route
- **Confidence Scoring**: Indicates reliability of each recommendation (0-100%)
- **Driver Feedback**: Tracks which routes are accepted and their actual results

### 4. Analytics & Reporting
- **Traffic Dashboard**: Real-time overview of fleet traffic status
- **Trip Analysis Reports**: Detailed reports for each completed trip
- **Analytics Dashboard**: Comprehensive metrics and KPIs
- **Congestion Hotspots**: Identifies frequently congested areas
- **Performance Metrics**: Tracks ROI and cost savings

---

## Database Schema

### TrafficData Table
Stores real-time vehicle position and speed data:
- `vehicle_id` - Vehicle reference
- `trip_id` - Associated trip
- `latitude`, `longitude` - Location coordinates
- `speed` - Current speed (km/h)
- `heading` - Direction (0-360°)
- `timestamp` - Data capture time
- `congestion_level` - auto-calculated (low/moderate/high/severe)

### RouteAnalysis Table
Stores analysis of completed trips:
- `trip_id` - Reference to trip
- `original_route` - Route description
- `average_speed` - Average speed during trip
- `max_speed`, `min_speed` - Speed extremes
- `total_distance` - Trip distance
- `estimated_time` - Expected travel time
- `actual_time` - Actual travel time
- `congestion_segments` - JSON array of congested areas

### RouteRecommendation Table
Stores alternative route suggestions:
- `route_analysis_id` - Reference to analysis
- `trip_id` - Associated trip
- `alternative_route` - Route description
- `estimated_time_saved` - Predicted time savings
- `distance` - Route distance
- `confidence_level` - Accuracy percentage (0-100)
- `status` - pending/sent/accepted/rejected/in_progress/completed
- `accepted_by_driver` - Boolean flag
- `actual_time_saved` - Real-world time saved

---

## API Endpoints

### Traffic Data Collection
```
POST /traffic/record-data
```
Record real-time vehicle location and speed data.

**Request:**
```json
{
  "vehicle_id": 1,
  "trip_id": 5,
  "latitude": -33.8688,
  "longitude": 151.2093,
  "speed": 45.5,
  "heading": 270
}
```

### Get Active Traffic Status
```
GET /traffic/active-status
```
Returns real-time traffic data for all active vehicles.

### Analyze Completed Trip
```
POST /traffic/trips/{trip}/analyze
```
Analyze a completed trip and generate route recommendations.

### Get Trip Recommendations
```
GET /traffic/trips/{trip}/recommendations
```
Retrieve all alternative route suggestions for a trip.

### Update Recommendation Status
```
PATCH /traffic/recommendations/{recommendation}/status
```
Update whether a recommendation was accepted and record actual time saved.

### Get Congestion Hotspots
```
GET /traffic/congestion-hotspots
```
Returns frequently congested areas with incident counts.

### Vehicle Traffic History
```
GET /traffic/vehicle/{vehicleId}/history
```
Get traffic data history for a specific vehicle (last 7 days, paginated).

---

## Web Routes

### Dashboard & Views
- `/traffic/dashboard` - Real-time traffic overview
- `/traffic/trips/{trip}/analysis` - Trip analysis report
- `/traffic/analytics` - Analytics and KPIs dashboard

---

## Service Class: TrafficAnalysisService

The core service handles all traffic analysis logic:

### Key Methods

#### `recordTrafficData()`
Records real-time GPS data and calculates congestion level.

#### `analyzeTripRoute(Trip $trip)`
Analyzes a completed trip to identify congestion patterns and generates recommendations.

#### `identifyCongestionSegments()`
Detects continuous periods where speed drops below thresholds.

#### `generateRouteRecommendations()`
Creates alternative route suggestions based on identified congestion.

#### `getActiveTrafficStatus()`
Returns current traffic status for all active trips.

#### `getTripRecommendations()`
Retrieves all recommendations for a specific trip.

---

## Congestion Thresholds

The system categorizes traffic based on vehicle speed:
- **Low**: > 80 km/h
- **Moderate**: 60-80 km/h
- **High**: 40-60 km/h
- **Severe**: < 40 km/h

---

## Integration Guide

### 1. Record Traffic Data (from GPS devices)
```php
// In your GPS data processing code
$this->trafficService->recordTrafficData(
    vehicleId: $vehicle->id,
    tripId: $trip->id,
    latitude: $gpsData['lat'],
    longitude: $gpsData['lon'],
    speed: $gpsData['speed'],
    heading: $gpsData['heading']
);
```

### 2. Analyze Completed Trips
```php
// When trip is marked as completed
$trip->update(['status' => 'completed']);
$this->trafficService->analyzeTripRoute($trip);
```

### 3. Send Recommendations to Drivers
```php
// Integration with driver notification system
$recommendations = $trip->routeRecommendations()
    ->where('status', 'pending')
    ->get();

foreach ($recommendations as $recommendation) {
    // Send to driver app/SMS/notification system
    notifyDriver($trip->driver, $recommendation);
    $recommendation->update(['status' => 'sent']);
}
```

### 4. Track Recommendation Results
```php
// When driver provides feedback
$recommendation->update([
    'status' => 'completed',
    'accepted_by_driver' => $driverAccepted,
    'actual_time_saved' => $realTimeSaved
]);
```

---

## Performance Optimization

- **Indexes**: TrafficData and RouteRecommendation tables have indexes on frequently queried columns
- **Pagination**: API responses are paginated for large datasets
- **JSON Storage**: Congestion segments stored as JSON for flexible storage
- **Query Eager Loading**: Relationships are eager-loaded to prevent N+1 queries

---

## Implementation Checklist

- [x] Create TrafficData model and migration
- [x] Create RouteAnalysis model and migration
- [x] Create RouteRecommendation model and migration
- [x] Create TrafficAnalysisService
- [x] Create TrafficController with all endpoints
- [x] Update Trip and Vehicle models with relationships
- [x] Create traffic dashboard view
- [x] Create trip analysis view
- [x] Create analytics dashboard view
- [x] Add routes to web.php
- [ ] Run migrations: `php artisan migrate`
- [ ] Set up GPS data collection integration
- [ ] Configure driver notification system
- [ ] Test trip analysis workflow

---

## Next Steps

1. **Run Migrations**:
   ```bash
   php artisan migrate
   ```

2. **Integrate GPS Data Collection**: Connect your vehicle GPS devices to send data to `/traffic/record-data`

3. **Set Up Notifications**: Implement driver notification system to send route recommendations

4. **Configuration**: Adjust congestion thresholds in `TrafficAnalysisService` if needed

5. **Testing**: Test the full workflow:
   - Record traffic data
   - Complete a trip
   - Analyze the trip
   - Accept/reject recommendations
   - View analytics

---

## Metrics Tracked

- **Trip Analysis**: Total trips analyzed, average speed, distance, time variance
- **Route Optimization**: Recommendations sent, acceptance rate, time saved
- **Congestion**: Incident count, severity levels, location hotspots
- **Fleet Performance**: On-time arrival rate, average trip duration, fuel saved (estimated)
- **ROI**: Cost reduction, driver hours saved, efficiency gains

---

## Cost Savings Calculation

The system estimates savings based on:
- Time saved per route (minutes)
- Fuel consumption reduction
- Driver productivity gains
- Reduced vehicle wear and tear

Example: If average fuel cost is $3/liter and system saves 2,847 liters annually, that's $8,542 in direct savings.

---

## Support & Customization

The system is designed to be extensible. You can:
- Adjust congestion thresholds
- Modify route recommendation logic
- Add additional traffic data sources
- Integrate with mapping APIs
- Customize notification messages
- Add machine learning models for better predictions

---

## Files Created

```
app/Models/
  - TrafficData.php
  - RouteAnalysis.php
  - RouteRecommendation.php

app/Services/
  - TrafficAnalysisService.php

app/Http/Controllers/
  - TrafficController.php

database/migrations/
  - 2026_03_19_000001_create_traffic_data_table.php
  - 2026_03_19_000002_create_route_analyses_table.php
  - 2026_03_19_000003_create_route_recommendations_table.php

resources/views/traffic/
  - dashboard.blade.php
  - trip_analysis.blade.php
  - analytics.blade.php

routes/
  - web.php (updated)
```

---

**Version**: 1.0  
**Last Updated**: March 19, 2026  
**Created For**: CSC 305 Fleet Management System
