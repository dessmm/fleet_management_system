# Fleet Management System - API Documentation

Complete API reference for the Fleet Management and Traffic Detection System.

---

## 📌 Base URL
```
http://localhost:8000
```

---

## 🚗 Vehicle Management APIs

### List All Vehicles
```
GET /vehicles

Response (200 OK):
{
  "data": [
    {
      "id": 1,
      "plate_number": "ABC-1234",
      "make": "Toyota",
      "model": "Hiace",
      "type": "Delivery Truck",
      "status": "available",
      "capacity": 1500,
      "year": 2022,
      "fuel_type": "Diesel",
      "mileage": 45000,
      "created_at": "2026-03-18T10:30:00Z",
      "updated_at": "2026-03-19T14:22:00Z"
    }
  ],
  "total": 15,
  "per_page": 15
}
```

### Create Vehicle
```
POST /vehicles
Content-Type: application/json

Request:
{
  "plate_number": "XYZ-9876",
  "make": "Volvo",
  "model": "FH16",
  "type": "Heavy Truck",
  "capacity": 25000,
  "status": "available",
  "year": 2023,
  "fuel_type": "Diesel",
  "mileage": 12500
}

Response (201 Created):
{
  "id": 16,
  "plate_number": "XYZ-9876",
  "make": "Volvo",
  "model": "FH16",
  "type": "Heavy Truck",
  "capacity": 25000,
  "status": "available",
  "year": 2023,
  "fuel_type": "Diesel",
  "mileage": 12500,
  "created_at": "2026-03-19T15:00:00Z"
}
```

### Get Vehicle Details
```
GET /vehicles/{id}

Response (200 OK):
{
  "id": 1,
  "plate_number": "ABC-1234",
  "make": "Toyota",
  "model": "Hiace",
  "type": "Delivery Truck",
  "status": "available",
  "capacity": 1500,
  "year": 2022,
  "fuel_type": "Diesel",
  "mileage": 45000,
  "trips": [
    {
      "id": 5,
      "vehicle_id": 1,
      "start_location": "Downtown Terminal",
      "end_location": "Airport",
      "status": "completed",
      "distance": 25.5
    }
  ],
  "maintenance_records": [
    {
      "id": 8,
      "service_date": "2026-03-15",
      "cost": 450.00,
      "notes": "Oil change and filter replacement"
    }
  ]
}
```

### Update Vehicle
```
PUT /vehicles/{id}
Content-Type: application/json

Request:
{
  "status": "in_maintenance",
  "mileage": 47200
}

Response (200 OK):
{
  "id": 1,
  "plate_number": "ABC-1234",
  "status": "in_maintenance",
  "mileage": 47200,
  "updated_at": "2026-03-19T15:30:00Z"
}
```

### Delete Vehicle
```
DELETE /vehicles/{id}

Response (204 No Content)
```

---

## 👥 Driver Management APIs

### List All Drivers
```
GET /drivers

Response (200 OK):
{
  "data": [
    {
      "id": 1,
      "name": "John Smith",
      "license_number": "DL-2024-12345",
      "contact": "+1 (555) 123-4567",
      "email": "john.smith@example.com",
      "status": "active",
      "date_of_birth": "1990-05-15",
      "license_expiry_date": "2029-12-31",
      "license_class": "D",
      "experience_years": 10,
      "created_at": "2026-03-18T09:00:00Z"
    }
  ],
  "total": 8,
  "per_page": 15
}
```

### Register New Driver
```
POST /drivers
Content-Type: application/json

Request:
{
  "name": "Sarah Johnson",
  "license_number": "DL-2024-54321",
  "contact": "+1 (555) 987-6543",
  "email": "sarah.j@example.com",
  "status": "active",
  "date_of_birth": "1988-03-22",
  "license_expiry_date": "2028-06-30",
  "license_class": "C",
  "experience_years": 8,
  "emergency_contact": "+1 (555) 111-2222"
}

Response (201 Created):
{
  "id": 9,
  "name": "Sarah Johnson",
  "license_number": "DL-2024-54321",
  "contact": "+1 (555) 987-6543",
  "status": "active",
  "created_at": "2026-03-19T15:45:00Z"
}
```

### Get Driver Details
```
GET /drivers/{id}

Response (200 OK):
{
  "id": 1,
  "name": "John Smith",
  "license_number": "DL-2024-12345",
  "contact": "+1 (555) 123-4567",
  "email": "john.smith@example.com",
  "status": "active",
  "date_of_birth": "1990-05-15",
  "license_expiry_date": "2029-12-31",
  "license_class": "D",
  "experience_years": 10,
  "emergency_contact": "+1 (555) 555-5555",
  "trips": [
    {
      "id": 5,
      "vehicle_id": 1,
      "status": "completed",
      "distance": 25.5,
      "start_time": "2026-03-19T08:00:00Z",
      "end_time": "2026-03-19T08:48:00Z"
    }
  ],
  "total_trips": 32,
  "completed_trips": 30
}
```

### Update Driver
```
PUT /drivers/{id}
Content-Type: application/json

Request:
{
  "contact": "+1 (555) 999-8888",
  "status": "inactive"
}

Response (200 OK):
{
  "id": 1,
  "name": "John Smith",
  "contact": "+1 (555) 999-8888",
  "status": "inactive",
  "updated_at": "2026-03-19T16:00:00Z"
}
```

---

## 🗺️ Trip Management APIs

### List All Trips
```
GET /trips

Query Parameters (optional):
  ?status=in_progress
  ?vehicle_id=1
  ?driver_id=3
  ?page=1&per_page=20

Response (200 OK):
{
  "data": [
    {
      "id": 5,
      "vehicle_id": 1,
      "driver_id": 3,
      "start_location": "Downtown Terminal",
      "end_location": "Airport Distribution Center",
      "start_time": "2026-03-19T08:00:00Z",
      "end_time": "2026-03-19T08:48:00Z",
      "distance": 25.5,
      "status": "completed",
      "vehicle": {
        "id": 1,
        "plate_number": "ABC-1234",
        "make": "Toyota"
      },
      "driver": {
        "id": 3,
        "name": "John Smith",
        "license_number": "DL-2024-12345"
      }
    }
  ],
  "total": 247,
  "per_page": 15
}
```

### Create Trip
```
POST /trips
Content-Type: application/json

Request:
{
  "vehicle_id": 1,
  "driver_id": 3,
  "start_location": "Downtown Terminal",
  "end_location": "Airport Distribution Center",
  "start_time": "2026-03-20T08:00:00Z",
  "distance": 25.5,
  "status": "pending"
}

Response (201 Created):
{
  "id": 248,
  "vehicle_id": 1,
  "driver_id": 3,
  "start_location": "Downtown Terminal",
  "end_location": "Airport Distribution Center",
  "start_time": "2026-03-20T08:00:00Z",
  "distance": 25.5,
  "status": "pending",
  "created_at": "2026-03-19T16:15:00Z"
}
```

### Get Trip Details
```
GET /trips/{id}

Response (200 OK):
{
  "id": 5,
  "vehicle_id": 1,
  "driver_id": 3,
  "start_location": "Downtown Terminal",
  "end_location": "Airport Distribution Center",
  "start_time": "2026-03-19T08:00:00Z",
  "end_time": "2026-03-19T08:48:00Z",
  "distance": 25.5,
  "status": "completed",
  "vehicle": {
    "id": 1,
    "plate_number": "ABC-1234",
    "make": "Toyota",
    "model": "Hiace"
  },
  "driver": {
    "id": 3,
    "name": "John Smith"
  },
  "location_logs_count": 61,
  "analysis_available": true
}
```

### Update Trip Status
```
PUT /trips/{id}
Content-Type: application/json

Request:
{
  "status": "in_progress"
}

Response (200 OK):
{
  "id": 248,
  "status": "in_progress",
  "updated_at": "2026-03-20T08:05:00Z"
}
```

---

## 📍 Traffic & Location Tracking APIs

### Record GPS Location Data
**Endpoint:** `POST /traffic/record-data`

Used by mobile devices/GPS trackers to submit location data every 30 seconds during a trip.

```
POST /traffic/record-data
Content-Type: application/json

Request:
{
  "vehicle_id": 1,
  "trip_id": 5,
  "latitude": 40.7128,
  "longitude": -74.0060,
  "speed": 45.5,
  "heading": 180,
  "altitude": 10.5,
  "accuracy": 5.0,
  "recorded_at": "2026-03-19T08:15:00Z"
}

Response (201 Created):
{
  "id": 547,
  "vehicle_id": 1,
  "trip_id": 5,
  "latitude": 40.7128,
  "longitude": -74.0060,
  "speed": 45.5,
  "heading": 180,
  "congestion_level": "high",
  "timestamp": "2026-03-19T08:15:00Z",
  "created_at": "2026-03-19T08:15:02Z"
}
```

**Congestion Levels:**
- `low` - Speed > 80 km/h (🟢 Green)
- `moderate` - Speed 60-80 km/h (🟡 Yellow)
- `high` - Speed 40-60 km/h (🟠 Orange)
- `severe` - Speed < 40 km/h (🔴 Red)

---

### Get Real-time Traffic Status
**Endpoint:** `GET /traffic/active-status`

Get current status of all active vehicles on the road.

```
GET /traffic/active-status

Response (200 OK):
[
  {
    "trip_id": 5,
    "vehicle_id": 1,
    "route": "Downtown → Airport",
    "current_speed": 42.3,
    "congestion_level": "high",
    "location": {
      "latitude": 40.7200,
      "longitude": -74.0080
    },
    "timestamp": "2026-03-19T08:20:00Z",
    "driver_name": "John Smith"
  },
  {
    "trip_id": 6,
    "vehicle_id": 3,
    "route": "Port → Distribution Center",
    "current_speed": 75.0,
    "congestion_level": "moderate",
    "location": {
      "latitude": 40.6800,
      "longitude": -73.9500
    },
    "timestamp": "2026-03-19T08:20:00Z",
    "driver_name": "Sarah Johnson"
  }
]
```

---

### Get Traffic Congestion Hotspots
**Endpoint:** `GET /traffic/congestion-hotspots`

Identify areas with frequent traffic congestion.

```
GET /traffic/congestion-hotspots

Response (200 OK):
{
  "hotspots": [
    {
      "location": {
        "latitude": 40.7580,
        "longitude": -73.9855
      },
      "severity": "high",
      "vehicles_affected": 3,
      "average_speed": 28.5,
      "last_updated": "2026-03-19T08:20:00Z"
    },
    {
      "location": {
        "latitude": 40.7489,
        "longitude": -73.9680
      },
      "severity": "moderate",
      "vehicles_affected": 2,
      "average_speed": 55.0,
      "last_updated": "2026-03-19T08:18:00Z"
    }
  ],
  "total_hotspots": 2,
  "timestamp": "2026-03-19T08:20:00Z"
}
```

---

### Get Vehicle Location History
**Endpoint:** `GET /traffic/vehicle/{vehicleId}/history`

Get all historical location data for a specific vehicle.

```
GET /traffic/vehicle/1/history?since=2026-03-19T08:00:00Z&limit=100

Response (200 OK):
{
  "vehicle_id": 1,
  "plate_number": "ABC-1234",
  "locations": [
    {
      "id": 545,
      "latitude": 40.7100,
      "longitude": -74.0050,
      "speed": 55.0,
      "congestion_level": "moderate",
      "recorded_at": "2026-03-19T08:10:00Z"
    },
    {
      "id": 546,
      "latitude": 40.7115,
      "longitude": -74.0055,
      "speed": 45.5,
      "congestion_level": "high",
      "recorded_at": "2026-03-19T08:15:00Z"
    },
    {
      "id": 547,
      "latitude": 40.7128,
      "longitude": -74.0060,
      "speed": 42.3,
      "congestion_level": "high",
      "recorded_at": "2026-03-19T08:20:00Z"
    }
  ],
  "total": 65,
  "period": "2026-03-19T08:00:00Z to 2026-03-19T09:00:00Z"
}
```

---

## 📊 Trip Analysis & Route Recommendations APIs

### Analyze Completed Trip
**Endpoint:** `POST /traffic/trips/{trip}/analyze`

Triggers analysis of a completed trip to identify traffic patterns and generate route recommendations.

```
POST /traffic/trips/5/analyze

Response (201 Created):
{
  "analysis_id": 12,
  "trip_id": 5,
  "vehicle_id": 1,
  "original_route": "Downtown Terminal → Airport Distribution Center",
  "average_speed": 42.3,
  "max_speed": 65.0,
  "min_speed": 15.0,
  "total_distance": 25.5,
  "estimated_time": 36,
  "actual_time": 48,
  "delay_minutes": 12,
  "congestion_segments": [
    {
      "segment": 1,
      "start_time": "2026-03-19T08:05:00Z",
      "end_time": "2026-03-19T08:25:00Z",
      "duration_minutes": 20,
      "average_speed": 28.5,
      "start_location": {
        "latitude": 40.7200,
        "longitude": -74.0080
      }
    }
  ],
  "recommendations_generated": 3,
  "analysis_date": "2026-03-19T09:00:00Z"
}
```

---

### Get Trip Analysis
**Endpoint:** `GET /traffic/trips/{trip}/analysis`

Retrieve previously generated analysis for a trip.

```
GET /traffic/trips/5/analysis

Response (200 OK):
{
  "id": 12,
  "trip_id": 5,
  "vehicle_id": 1,
  "original_route": "Downtown Terminal → Airport Distribution Center",
  "average_speed": 42.3,
  "max_speed": 65.0,
  "min_speed": 15.0,
  "total_distance": 25.5,
  "estimated_time_minutes": 36,
  "actual_time_minutes": 48,
  "time_delay_minutes": 12,
  "congestion_segments": [
    {
      "segment": 1,
      "name": "Lincoln Tunnel Area",
      "start_time": "2026-03-19T08:05:00Z",
      "end_time": "2026-03-19T08:25:00Z",
      "duration_minutes": 20,
      "average_speed": 28.5,
      "start_location": {
        "latitude": 40.7200,
        "longitude": -74.0080
      }
    }
  ],
  "analysis_date": "2026-03-19T09:00:00Z"
}
```

---

### Get Route Recommendations
**Endpoint:** `GET /traffic/trips/{trip}/recommendations`

Get alternative route suggestions for a trip based on analysis.

```
GET /traffic/trips/5/recommendations

Response (200 OK):
{
  "trip_id": 5,
  "original_route": "Downtown Terminal → Airport Distribution Center",
  "original_time_minutes": 48,
  "recommendations": [
    {
      "id": 1,
      "route_number": 1,
      "alternative_route": "Via FDR Drive and Queens Midtown Tunnel",
      "estimated_time_saved": 8.5,
      "estimated_time_minutes": 39.5,
      "distance": 24.8,
      "confidence_level": 78,
      "status": "pending",
      "accepted_by_driver": false,
      "actual_time_saved": null
    },
    {
      "id": 2,
      "route_number": 2,
      "alternative_route": "Via Brooklyn Bridge and Long Island Expressway",
      "estimated_time_saved": 10.2,
      "estimated_time_minutes": 37.8,
      "distance": 26.1,
      "confidence_level": 83,
      "status": "pending",
      "accepted_by_driver": false,
      "actual_time_saved": null
    },
    {
      "id": 3,
      "route_number": 3,
      "alternative_route": "Different departure time (off-peak travel)",
      "estimated_time_saved": 5.5,
      "estimated_time_minutes": 42.5,
      "distance": 25.5,
      "confidence_level": 71,
      "status": "pending",
      "accepted_by_driver": false,
      "actual_time_saved": null
    }
  ],
  "total_recommendations": 3,
  "analysis_id": 12
}
```

---

### Update Recommendation Status
**Endpoint:** `PATCH /traffic/recommendations/{id}/status`

Driver accepts or rejects a route recommendation.

```
PATCH /traffic/recommendations/2/status
Content-Type: application/json

Request:
{
  "status": "accepted",
  "accepted_by_driver": true,
  "actual_time_saved": 10.5
}

Response (200 OK):
{
  "id": 2,
  "alternative_route": "Via Brooklyn Bridge and Long Island Expressway",
  "status": "accepted",
  "accepted_by_driver": true,
  "estimated_time_saved": 10.2,
  "actual_time_saved": 10.5,
  "updated_at": "2026-03-19T09:15:00Z"
}
```

**Status Values:**
- `pending` - Initial state, awaiting driver review
- `accepted` - Driver accepted the recommendation
- `rejected` - Driver rejected the recommendation
- `expired` - Recommendation no longer valid (trip completed)

---

## 📈 Dashboard & Analytics APIs

### Traffic Dashboard
**Endpoint:** `GET /traffic/dashboard`

Get overview data for traffic management dashboard.

```
GET /traffic/dashboard

Response (200 OK):
{
  "summary": {
    "active_vehicles": 5,
    "active_trips": 4,
    "pending_recommendations": 8,
    "average_congestion": "high"
  },
  "active_traffic": [
    {
      "trip_id": 5,
      "vehicle_id": 1,
      "route": "Downtown → Airport",
      "current_speed": 42.3,
      "congestion_level": "high",
      "timestamp": "2026-03-19T08:20:00Z"
    }
  ],
  "recent_analyses": [
    {
      "id": 12,
      "trip_id": 5,
      "average_speed": 42.3,
      "actual_time": 48,
      "estimated_time": 36,
      "analysis_date": "2026-03-19T09:00:00Z"
    }
  ],
  "hotspots": [
    {
      "location": "Downtown/Lincoln Tunnel",
      "severity": "high",
      "affected_vehicles": 3
    }
  ]
}
```

---

### Analytics Dashboard
**Endpoint:** `GET /traffic/analytics`

Get detailed analytics and reports.

```
GET /traffic/analytics

Response (200 OK):
{
  "kpis": {
    "total_trips": 247,
    "completed_trips": 234,
    "completion_rate": 94.7,
    "avg_time_difference_minutes": 8.2,
    "avg_distance_km": 24.3,
    "avg_speed_kmh": 48.2,
    "recommendation_adoption_rate": 68.5,
    "avg_time_saved_minutes": 9.3
  },
  "traffic_trends": {
    "high_congestion_hours": ["08:00-09:00", "17:00-18:30"],
    "common_hotspots": ["Downtown", "Lincoln Tunnel", "FDR Drive"],
    "avg_congestion_by_hour": {
      "08:00": "high",
      "09:00": "moderate",
      "10:00": "moderate",
      "17:00": "severe",
      "18:00": "high"
    }
  },
  "vehicle_stats": {
    "total_vehicles": 15,
    "available": 8,
    "in_maintenance": 4,
    "out_of_service": 3
  },
  "recommendation_stats": {
    "total_generated": 145,
    "accepted": 99,
    "rejected": 34,
    "pending": 12,
    "adoption_rate": 68.3
  },
  "top_drivers": [
    {
      "driver_id": 3,
      "name": "John Smith",
      "trips_completed": 32,
      "avg_delay_minutes": 5.2,
      "recommendations_accepted": 21
    }
  ]
}
```

---

## 🔒 Error Responses

### 400 Bad Request
```json
{
  "message": "Invalid request data",
  "errors": {
    "vehicle_id": ["The vehicle_id field is required"],
    "latitude": ["The latitude must be between -90 and 90"]
  }
}
```

### 404 Not Found
```json
{
  "message": "Resource not found",
  "resource": "Vehicle",
  "id": 999
}
```

### 422 Unprocessable Entity
```json
{
  "message": "The trip has invalid status for analysis",
  "trip_id": 5,
  "current_status": "pending",
  "required_status": "completed"
}
```

### 500 Internal Server Error
```json
{
  "message": "Internal server error",
  "error_code": "ERR_500",
  "timestamp": "2026-03-19T08:30:00Z"
}
```

---

## 🧪 Test Scenarios

### Scenario 1: Create Trip and Submit GPS Data
1. `POST /trips` - Create new trip
2. `PUT /trips/{id}` - Update status to "in_progress"
3. `POST /traffic/record-data` - Submit GPS point (repeat 50+ times)
4. `PUT /trips/{id}` - Update status to "completed"
5. `POST /traffic/trips/{trip}/analyze` - Analyze trip
6. `GET /traffic/trips/{trip}/recommendations` - Get suggestions

### Scenario 2: Real-time Traffic Monitoring
1. `GET /traffic/active-status` - See active vehicles
2. `GET /traffic/congestion-hotspots` - Identify problem areas
3. `GET /traffic/vehicle/{id}/history` - Check vehicle path
4. `GET /traffic/dashboard` - View dashboard

### Scenario 3: Driver Decision Making
1. `GET /traffic/trips/{trip}/recommendations` - See options
2. `PATCH /traffic/recommendations/{id}/status` - Accept option
3. Next trip: Driver uses accepted route
4. `POST /traffic/record-data` - Submit location (different route)
5. System learns from feedback

---

**API Version:** 1.0  
**Last Updated:** March 19, 2026  
**Status:** Production Ready
