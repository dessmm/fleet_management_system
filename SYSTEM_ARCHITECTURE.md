# Fleet Management and Traffic Detection System
## Complete System Documentation

---

## 📋 Table of Contents

1. [System Overview](#system-overview)
2. [Architecture](#architecture)
3. [Database Schema](#database-schema)
4. [API Endpoints](#api-endpoints)
5. [Core Features](#core-features)
6. [Setup Instructions](#setup-instructions)
7. [Usage Examples](#usage-examples)
8. [System Components](#system-components)

---

## System Overview

This is a comprehensive fleet management system with real-time traffic detection and route optimization capabilities. It enables fleet managers to:

- **Track vehicles** in real-time using GPS data
- **Detect traffic congestion** by analyzing vehicle speeds and density
- **Suggest alternative routes** to drivers to reduce travel time
- **Monitor driver performance** and trip analytics
- **Manage maintenance** schedules and fuel consumption

### Key Technologies

- **Backend:** Laravel 11 (PHP)
- **Database:** MySQL
- **Frontend:** Blade Templates with Tailwind CSS
- **Real-time Data:** GPS location logging and traffic analysis
- **API:** RESTful endpoints for mobile/third-party integration

---

## Architecture

### High-Level System Flow

```
Mobile/GPS Device
    ↓
LocationLog API Endpoint
    ↓
Store in location_logs table
    ↓
TrafficAnalysisService (analyzes data)
    ↓
Generate TrafficData (aggregated)
    ↓
Detect Congestion Segments
    ↓
Generate RouteRecommendations
    ↓
Driver receives suggestions via dashboard
```

### Layered Architecture

```
┌─────────────────────────────────────────────────────────┐
│          User Interface (Blade Views)                    │
│  - Admin Dashboard  - Driver Interface                   │
│  - Vehicle tracking - Trip analytics                     │
└──────────────────┬──────────────────────────────────────┘
                    │
┌──────────────────┴──────────────────────────────────────┐
│          Controllers (HTTP Request Handlers)             │
│  - VehicleController   - DriverController               │
│  - TripController      - TrafficController              │
│  - LocationController  - RouteController                │
└──────────────────┬──────────────────────────────────────┘
                    │
┌──────────────────┴──────────────────────────────────────┐
│          Services (Business Logic)                       │
│  - TrafficAnalysisService (core traffic detection)      │
│  - RouteOptimizationService (alternative routes)        │
│  - NotificationService (send recommendations)           │
└──────────────────┬──────────────────────────────────────┘
                    │
┌──────────────────┴──────────────────────────────────────┐
│          Models (Data Representation)                    │
│  - Vehicle, Driver, Trip, Maintenance, FuelRecord      │
│  - LocationLog, TrafficData, RouteRecommendation       │
│  - RouteAnalysis, Assignment                            │
└──────────────────┬──────────────────────────────────────┘
                    │
┌──────────────────┴──────────────────────────────────────┐
│          Database (MySQL)                                │
│  - 14+ tables with proper indexes and relationships     │
└─────────────────────────────────────────────────────────┘
```

---

## Database Schema

### Complete ERD

```
Vehicles (Core Fleet)
├── id (PK)
├── plate_number (Unique)
├── make, model, type
├── status (available, in_maintenance, out_of_service)
├── capacity (kg)
├── year, fuel_type, mileage
└── Relationships:
    ├── hasMany: Trips
    ├── hasMany: MaintenanceRecords
    ├── hasMany: FuelRecords
    ├── hasMany: LocationLogs
    ├── hasMany: TrafficData

Drivers (Fleet Personnel)
├── id (PK)
├── name, license_number, contact
├── status (active, inactive)
├── date_of_birth, address
├── email, emergency_contact
├── experience_years, license_class
└── Relationships:
    ├── hasMany: Trips
    ├── hasMany: RouteRecommendations
    └── hasMany: Assignments

Trips (Journey Records)
├── id (PK)
├── vehicle_id (FK), driver_id (FK)
├── start_location, end_location
├── start_time, end_time, distance
├── status (pending, in_progress, completed)
└── Relationships:
    ├── belongsTo: Vehicle
    ├── belongsTo: Driver
    ├── hasMany: LocationLogs
    ├── hasMany: TrafficData
    ├── hasOne: RouteAnalysis
    └── hasMany: RouteRecommendations

LocationLogs (Raw GPS Data)
├── id (PK)
├── vehicle_id (FK), trip_id (FK)
├── latitude, longitude
├── speed (km/h), heading (0-360°)
├── altitude, accuracy
├── recorded_at (timestamp)
└── Relationships:
    ├── belongsTo: Vehicle
    └── belongsTo: Trip

TrafficData (Aggregated Analysis)
├── id (PK)
├── vehicle_id (FK), trip_id (FK)
├── latitude, longitude
├── speed (km/h)
├── congestion_level (low, moderate, high, severe)
├── timestamp
└── Relationships:
    ├── belongsTo: Vehicle
    └── belongsTo: Trip

RouteAnalysis (Trip Post-Analysis)
├── id (PK)
├── trip_id (FK)
├── original_route
├── average_speed, max_speed, min_speed
├── total_distance, estimated_time, actual_time
├── congestion_segments (JSON)
├── analysis_date
└── Relationships:
    ├── belongsTo: Trip
    └── hasMany: RouteRecommendations

RouteRecommendation (Alternative Route Suggestions)
├── id (PK)
├── route_analysis_id (FK)
├── trip_id (FK)
├── alternative_route (description)
├── estimated_time_saved (minutes)
├── actual_time_saved (minutes)
├── distance (km)
├── confidence_level (0-100)
├── status (pending, accepted, rejected, expired)
├── accepted_by_driver (boolean)
└── Relationships:
    ├── belongsTo: RouteAnalysis
    └── belongsTo: Trip

MaintenanceRecords
├── id (PK)
├── vehicle_id (FK)
├── service_date, cost
├── technician_name, notes
└── Relationships:
    └── belongsTo: Vehicle

FuelRecords
├── id (PK)
├── vehicle_id (FK)
├── fuel_type, quantity, cost
├── refuel_date, fuel_efficiency
└── Relationships:
    └── belongsTo: Vehicle

Assignments
├── id (PK)
├── vehicle_id (FK), driver_id (FK)
├── assigned_date, status
└── Relationships:
    ├── belongsTo: Vehicle
    └── belongsTo: Driver
```

### Table Creation Order (Dependencies)

1. **users** (default Laravel)
2. **vehicles** (no dependencies)
3. **drivers** (no dependencies)
4. **trips** (depends on: vehicles, drivers)
5. **maintenance_records** (depends on: vehicles)
6. **fuel_records** (depends on: vehicles)
7. **assignments** (depends on: vehicles, drivers)
8. **location_logs** (depends on: vehicles, trips)
9. **traffic_data** (depends on: vehicles, trips)
10. **route_analyses** (depends on: trips)
11. **route_recommendations** (depends on: route_analyses, trips)

---

## API Endpoints

### Vehicle Management
```
GET    /vehicles              - List all vehicles
POST   /vehicles              - Create new vehicle
GET    /vehicles/{id}         - Get vehicle details
PUT    /vehicles/{id}         - Update vehicle
DELETE /vehicles/{id}         - Delete vehicle (soft delete recommended)
```

### Driver Management
```
GET    /drivers               - List all drivers
POST   /drivers               - Register new driver
GET    /drivers/{id}          - Get driver details
PUT    /drivers/{id}          - Update driver info
DELETE /drivers/{id}          - Remove driver
```

### Trip Management
```
GET    /trips                 - List trips
POST   /trips                 - Create new trip
GET    /trips/{id}            - Get trip details
PUT    /trips/{id}            - Update trip
GET    /trips/{trip}/analysis - Get trip analysis
```

### Traffic & Location APIs
```
POST   /traffic/record-data                      - Submit GPS location data
GET    /traffic/active-status                    - Get real-time traffic status
GET    /traffic/congestion-hotspots              - Get traffic hotspots
GET    /traffic/vehicle/{vehicleId}/history      - Get vehicle location history
POST   /traffic/trips/{trip}/analyze             - Analyze completed trip
GET    /traffic/trips/{trip}/recommendations     - Get route suggestions
PATCH  /traffic/recommendations/{rec}/status     - Accept/reject suggestion
```

### Dashboard & Analytics
```
GET    /traffic/dashboard     - Main traffic dashboard
GET    /traffic/analytics     - Detailed analytics
GET    /                      - Home/overview page
```

### API Request/Response Examples

#### Record GPS Location Data
```bash
# Request
POST /traffic/record-data
Content-Type: application/json

{
  "vehicle_id": 1,
  "trip_id": 5,
  "latitude": 40.7128,
  "longitude": -74.0060,
  "speed": 45.5,
  "heading": 180,
  "altitude": 10.5,
  "accuracy": 5.0
}

# Response (201 Created)
{
  "id": 1,
  "vehicle_id": 1,
  "trip_id": 5,
  "latitude": 40.7128,
  "longitude": -74.0060,
  "speed": 45.5,
  "congestion_level": "high",
  "timestamp": "2026-03-19T10:30:00Z"
}
```

#### Get Active Traffic Status
```bash
# Request
GET /traffic/active-status

# Response
[
  {
    "trip_id": 5,
    "vehicle_id": 1,
    "route": "Main St → Market St",
    "current_speed": 45.5,
    "congestion_level": "high",
    "location": {
      "latitude": 40.7128,
      "longitude": -74.0060
    },
    "timestamp": "2026-03-19T10:30:00Z"
  }
]
```

#### Analyze Completed Trip
```bash
# Request
POST /traffic/trips/5/analyze

# Response
{
  "trip_id": 5,
  "original_route": "Downtown → Airport",
  "average_speed": 42.3,
  "max_speed": 65.0,
  "min_speed": 15.0,
  "total_distance": 25.5,
  "estimated_time": 36,
  "actual_time": 48,
  "congestion_segments": [
    {
      "start_time": "2026-03-19T10:05:00Z",
      "end_time": "2026-03-19T10:20:00Z",
      "duration_minutes": 15,
      "average_speed": 28.5,
      "start_location": [40.7128, -74.0060]
    }
  ]
}
```

---

## Core Features

### 1. Fleet Management
- **Vehicle Tracking**: Monitor all vehicles with real-time status
- **Driver Management**: Comprehensive driver profile management
- **Trip Scheduling**: Create and track trips between locations
- **Maintenance Scheduling**: Track maintenance records and schedules
- **Fuel Monitoring**: Track fuel consumption and costs

### 2. Real-Time Vehicle Tracking
- **GPS Data Collection**: Collect location, speed, heading, altitude
- **Location History**: Maintain complete location logs per trip
- **Active Fleet View**: See all active vehicles on dashboard
- **Vehicle History**: Historical location data and traffic patterns

### 3. Traffic Detection Algorithm
```
Speed-Based Congestion Classification:
├── Severe (🔴): Speed < 40 km/h    → Heavy traffic
├── High   (🟠): 40-60 km/h         → Moderate traffic
├── Moderate(🟡): 60-80 km/h        → Light traffic
└── Low    (🟢): > 80 km/h          → Free flow

Congestion Segment Detection:
1. Identify continuous periods where speed < 40 km/h
2. Mark start/end times and duration
3. Calculate average speed during congestion
4. Store location coordinates of congestion start

Area-Level Congestion (Density-Based):
1. Group nearby vehicles (within 2km radius)
2. If 3+ vehicles have low speed in same area = congestion
3. Calculate area-level congestion index
```

### 4. Route Recommendation System
```
Recommendation Generation Logic:
1. Analyze trip post-completion
2. Identify congestion segments
3. For each segment:
   - Generate alternative route description
   - Estimate time savings (60% of delay recovered)
   - Assign confidence level (75% base + variance)
4. Create up to 3 alternative routes
5. Store with status: pending

Driver Interaction:
1. Driver receives suggestions for completed trip
2. Can accept/reject for future reference
3. Actual time saved recorded if accepted
4. Data used to improve future recommendations
```

### 5. Analytics & Dashboard
- **KPI Cards**: Active vehicles, active trips, avg traffic, recommendation adoption
- **Vehicle Status Breakdown**: Available, in maintenance, out of service
- **Trip Analytics**: Completion rate, average time vs estimated, traffic impact
- **Recommendation Stats**: Adoption rate, average time saved, confidence score
- **Historical Trends**: Traffic patterns, driver performance, fleet efficiency

---

## Setup Instructions

### Prerequisites
- PHP 8.2+
- MySQL 8.0+
- Composer
- Node.js (for frontend build if needed)

### Installation Steps

1. **Clone/Extract Project**
```bash
cd fleet_management_system
```

2. **Install Dependencies**
```bash
composer install
npm install
```

3. **Environment Setup**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Database Configuration**
Edit `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fleet_management_system
DB_USERNAME=root
DB_PASSWORD=
```

5. **Run Migrations**
```bash
php artisan migrate
```

6. **Seed Sample Data (Optional)**
```bash
php artisan db:seed
```

7. **Start Development Server**
```bash
php artisan serve
# Server running at http://localhost:8000
```

8. **Access Admin Dashboard**
```
http://localhost:8000/
```

---

## Usage Examples

### 1. Register a Vehicle
```blade
POST /vehicles
{
  "plate_number": "ABC-1234",
  "make": "Toyota",
  "model": "Hiace",
  "type": "Delivery Truck",
  "status": "available",
  "capacity": 1500,
  "year": 2022,
  "fuel_type": "Diesel"
}
```

### 2. Register a Driver
```blade
POST /drivers
{
  "name": "John Smith",
  "license_number": "DL-2024-12345",
  "contact": "+1 (555) 123-4567",
  "status": "active",
  "date_of_birth": "1990-05-15",
  "license_expiry_date": "2029-12-31",
  "license_class": "D",
  "experience_years": 10
}
```

### 3. Create a Trip
```blade
POST /trips
{
  "vehicle_id": 1,
  "driver_id": 3,
  "start_location": "Downtown Terminal",
  "end_location": "Airport Distribution Center",
  "start_time": "2026-03-19T08:00:00Z",
  "distance": 25.5,
  "status": "pending"
}
```

### 4. Log GPS Data During Trip
```bash
# Mobile app sends location every 30 seconds
POST /traffic/record-data
{
  "vehicle_id": 1,
  "trip_id": 5,
  "latitude": 40.7128,
  "longitude": -74.0060,
  "speed": 45.5,
  "heading": 180,
  "accuracy": 5.0,
  "recorded_at": "2026-03-19T08:15:00Z"
}
```

### 5. Analyze Completed Trip
```bash
# After trip completion
POST /traffic/trips/5/analyze

# System automatically:
# 1. Calculates average/max/min speeds
# 2. Identifies congestion segments
# 3. Estimates time saved with alternatives
# 4. Generates route recommendations
```

### 6. Get Route Recommendations
```bash
GET /traffic/trips/5/recommendations

# Response includes:
# - 3 alternative routes
# - Estimated time savings for each
# - Confidence level percentage
# - Driver can accept/reject
```

---

## System Components

### Controllers

#### TrafficController
- **recordData()**: Accept GPS location submissions
- **dashboard()**: Display real-time traffic overview
- **analytics()**: Show detailed analytics
- **analyzeTrip()**: Trigger trip analysis
- **getRecommendations()**: Retrieve route suggestions
- **updateRecommendationStatus()**: Record driver feedback

#### VehicleController
- CRUD operations for vehicle management
- Filter by status
- Maintenance tracking

#### DriverController
- CRUD operations for driver management
- License validation
- Performance metrics

#### TripController
- CRUD operations for trips
- Trip history
- Trip status updates

### Services

#### TrafficAnalysisService
```php
- recordTrafficData()           // Store GPS data
- analyzeTripRoute()           // Post-trip analysis
- identifyCongestionSegments() // Detect slow areas
- generateRouteRecommendations()// Create alternatives
- getActiveTrafficStatus()     // Real-time status
- calculateCongestionLevel()   // Speed-based classification
```

### Models & Relationships

All models include:
- Proper timestamps
- Mass fillable attributes
- Type casting for numeric/date fields
- Clear relationship definitions
- Index hints for database optimization

---

## Performance Optimization

### Database Indexes
- `location_logs`: (vehicle_id, recorded_at), (trip_id, recorded_at)
- `traffic_data`: (vehicle_id, timestamp), (trip_id, timestamp)
- `route_analyses`: (trip_id), (analysis_date)
- `route_recommendations`: (route_analysis_id), (trip_id), (status)

### Query Optimization
- Eager load relationships to avoid N+1 queries
- Use pagination for large result sets
- Cache frequently accessed data (fleet status, hotspots)
- Archive old location logs quarterly

### Scalability Considerations
1. **High-frequency GPS data**: Use queue jobs to process asynchronously
2. **Large fleets**: Implement sharding by vehicle_id or region
3. **Real-time dashboard**: Consider Redis for caching active vehicle status
4. **Historical analysis**: Archive location logs to separate database

---

## Testing the System

### Manual Testing Checklist

- [ ] Create vehicle - can add to database
- [ ] Create driver - all fields validate
- [ ] Create trip - links vehicle and driver correctly
- [ ] Submit GPS data - calculates congestion level
- [ ] Complete trip - triggers analysis automatically
- [ ] View recommendations - displays 3 alternatives
- [ ] Accept recommendation - updates driver feedback
- [ ] Dashboard - shows KPI cards with correct data
- [ ] Analytics - displays traffic trends

### API Testing
Use Postman or cURL for API endpoint testing:
```bash
# Test location recording
curl -X POST http://localhost:8000/traffic/record-data \
  -H "Content-Type: application/json" \
  -d '{
    "vehicle_id": 1,
    "trip_id": 1,
    "latitude": 40.7128,
    "longitude": -74.0060,
    "speed": 45.5
  }'
```

---

## Troubleshooting

### Common Issues

**"Column not found" error**
- Solution: Run `php artisan migrate` to create all tables

**Location data not appearing**
- Check vehicle_id and trip_id exist
- Verify GPS data has valid coordinates
- Check database connectivity

**Recommendations not generating**
- Trip must have LocationLog data
- Average speed must be < 80 km/h for analysis
- Check TrafficAnalysisService::analyzeTripRoute()

---

## Future Enhancements

1. **Mobile App Integration**: Native Android/iOS apps for drivers
2. **Real-time Map Visualization**: Interactive map with live vehicle positions
3. **Predictive Analytics**: ML-based traffic prediction
4. **Driver Notifications**: Push notifications for route recommendations
5. **Document Integration**: Integration with accounting/ERP systems
6. **Geofencing**: Define zones for automatic alerts
7. **Fuel Optimization**: Calculate most fuel-efficient routes
8. **Multi-language Support**: Support for multiple languages

---

## License & Support

Created for educational purposes as part of CSC 305 Midterm Project.

For issues or questions, review the code documentation or refer to Laravel official documentation.

---

**Last Updated:** March 19, 2026  
**Version:** 1.0  
**Status:** Complete & Production Ready
