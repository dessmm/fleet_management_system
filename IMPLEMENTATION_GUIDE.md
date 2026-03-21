# Fleet Management System - Complete Implementation

A comprehensive Laravel-based fleet management system with real-time traffic detection and route optimization.

## 🚀 Quick Start

### Prerequisites
- PHP 8.2+
- MySQL 8.0+
- Composer
- Node.js (optional, for frontend)

### Installation

1. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

2. **Configure environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Setup database**
   ```bash
   # Edit .env with your MySQL credentials
   DB_DATABASE=fleet_management_system
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Run migrations**
   ```bash
   php artisan migrate
   ```

5. **Start the server**
   ```bash
   php artisan serve
   ```

   Access at: `http://localhost:8000`

---

## 📊 Core Features

### ✅ Fleet Management
- **Vehicle Tracking**: Real-time GPS location tracking
- **Driver Management**: Comprehensive driver profiles with licenses
- **Trip Planning**: Schedule and monitor trips
- **Maintenance Tracking**: Schedule and log maintenance records
- **Fuel Management**: Track fuel consumption and costs

### ✅ Traffic Detection
- **Real-time Congestion Detection**: Analyzes vehicle speeds in real-time
- **Congestion Levels**: Severe, High, Moderate, Low classifications
- **Hotspot Identification**: Identify areas with frequent traffic
- **Historical Analysis**: Track traffic patterns over time

### ✅ Route Optimization
- **Alternative Route Suggestions**: Generate 3 alternative routes per trip
- **Time Savings Estimation**: Predict time saved with alternative routes
- **Confidence Scoring**: 0-100% confidence level per suggestion
- **Driver Feedback**: Track which suggestions drivers accept

### ✅ Analytics & Dashboard
- **KPI Cards**: Active vehicles, trips, avg traffic congestion
- **Real-time Fleet View**: See all vehicles and their status
- **Trip Analytics**: Speed analysis, time comparisons, traffic impact
- **Recommendation Stats**: Adoption rate, time saved, effectiveness

---

## 🏗️ System Architecture

### Database Tables (11+)

```
Core Entities:
├── vehicles              - Fleet vehicles
├── drivers              - Driver information
├── trips                - Journey records
├── maintenance_records  - Service history
├── fuel_records         - Fuel consumption

Real-time Tracking:
├── location_logs        - Raw GPS data (every 30 seconds)
├── traffic_data         - Processed/aggregated traffic info

Analysis & Recommendations:
├── route_analyses       - Post-trip analysis
├── route_recommendations - Alternative route suggestions

Fleet Operations:
├── assignments          - Vehicle-Driver assignments
```

### API Endpoints

#### Fleet Management
```
GET/POST   /vehicles                    - Vehicle CRUD
GET/POST   /drivers                     - Driver CRUD
GET/POST   /trips                       - Trip CRUD
GET/POST   /maintenance_records         - Maintenance CRUD
GET/POST   /fuel_records                - Fuel records CRUD
```

#### Traffic & Tracking
```
POST       /traffic/record-data                  - Submit GPS location
GET        /traffic/active-status                - Real-time traffic view
GET        /traffic/congestion-hotspots          - Traffic hotspots
GET        /traffic/vehicle/{id}/history         - Location history
POST       /traffic/trips/{trip}/analyze         - Analyze completed trip
GET        /traffic/trips/{trip}/recommendations - Get route suggestions
PATCH      /traffic/recommendations/{id}/status  - Accept/reject suggestion
```

#### Dashboards
```
GET        /                           - Home/overview
GET        /traffic/dashboard          - Traffic dashboard
GET        /traffic/analytics          - Detailed analytics
```

---

## 📱 Example Usage

### 1. Submit GPS Location Data
```bash
curl -X POST http://localhost:8000/traffic/record-data \
  -H "Content-Type: application/json" \
  -d '{
    "vehicle_id": 1,
    "trip_id": 5,
    "latitude": 40.7128,
    "longitude": -74.0060,
    "speed": 45.5,
    "heading": 180,
    "accuracy": 5.0
  }'
```

### 2. Get Real-time Traffic Status
```bash
curl http://localhost:8000/traffic/active-status

# Response includes all active trips with:
# - Current speed
# - Congestion level
# - Location coordinates
# - Real-time timestamp
```

### 3. Analyze Completed Trip
```bash
curl -X POST http://localhost:8000/traffic/trips/5/analyze

# Automatically generates:
# - Average/max/min speeds
# - Congestion segments (where vehicle slowed down)
# - Time comparisons (actual vs estimated)
# - 3 alternative route recommendations
```

### 4. Get Route Recommendations
```bash
curl http://localhost:8000/traffic/trips/5/recommendations

# Returns 3 alternatives with:
# - Route description
# - Estimated time saved
# - Confidence level (75-95%)
# - Current status (pending/accepted/rejected)
```

---

## 🎯 Traffic Detection Algorithm

### Speed-Based Congestion Classification
```
Speed (km/h)  →  Congestion Level  →  Status Indicator
< 40          →  SEVERE             →  🔴 Red
40-60         →  HIGH               →  🟠 Orange  
60-80         →  MODERATE           →  🟡 Yellow
> 80          →  LOW                →  🟢 Green
```

### Congestion Detection Process
1. **Collect GPS data** - vehicle location + speed every 30 seconds
2. **Classify speed** - assign congestion level based on speed
3. **Identify segments** - find continuous periods of low speed
4. **Store analysis** - record congestion start/end/duration
5. **Generate suggestions** - create alternative routes for driver

### Density-Based Hotspot Detection
- Group vehicles within 2km radius
- If 3+ vehicles have speed < 40 km/h in same area = hotspot
- Calculate area-level congestion index
- Display on traffic dashboard

---

## 🎨 User Interface

### Admin Dashboard
- **Fleet Overview**: All vehicles with status indicators
- **Real-time Map**: GPS positions of active vehicles
- **Traffic Dashboard**: Congestion hotspots and active routes
- **Analytics**: KPI cards, trend charts, performance metrics
- **Management Forms**: Add/edit vehicles, drivers, trips

### Driver Interface (Via Trip Details)
- **Route Recommendations**: 3 alternative routes with time savings
- **Trip Details**: Distance, estimated time, actual time
- **Congestion Alerts**: Real-time notifications on traffic
- **Feedback Options**: Accept/reject recommendations

### Forms (Modern Blade Templates)
- **Add Vehicle**: 12 fields organized in 3 sections
- **Add Driver**: 10 fields with validation and error messages
- **Create Trip**: Vehicle/driver selection, location inputs
- **Fuel Records**: Fuel type, quantity, cost tracking
- **Maintenance Records**: Service details and technician info

---

## 📦 Project Structure

```
fleet_management_system/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── HomeController.php
│   │   │   ├── VehicleController.php
│   │   │   ├── DriverController.php
│   │   │   ├── TripController.php
│   │   │   ├── TrafficController.php          ← Core traffic endpoints
│   │   │   ├── MaintenanceRecordController.php
│   │   │   └── FuelRecordController.php
│   ├── Models/
│   │   ├── Vehicle.php
│   │   ├── Driver.php
│   │   ├── Trip.php
│   │   ├── LocationLog.php                    ← Raw GPS data
│   │   ├── TrafficData.php                    ← Processed traffic
│   │   ├── RouteAnalysis.php                  ← Trip analysis
│   │   ├── RouteRecommendation.php            ← Route suggestions
│   │   ├── MaintenanceRecord.php
│   │   ├── FuelRecord.php
│   │   └── Assignments.php
│   ├── Services/
│   │   └── TrafficAnalysisService.php         ← Core business logic
├── database/
│   ├── migrations/
│   │   ├── create_vehicles_table.php
│   │   ├── create_drivers_table.php
│   │   ├── create_trips_table.php
│   │   ├── create_location_logs_table.php
│   │   ├── create_traffic_data_table.php
│   │   ├── create_route_analyses_table.php
│   │   ├── create_route_recommendations_table.php
│   │   └── ... (other tables)
├── resources/
│   ├── views/
│   │   ├── app.blade.php                      ← Main layout
│   │   ├── home.blade.php
│   │   ├── index.blade.php                    ← Vehicles list
│   │   ├── form.blade.php                     ← Vehicle form
│   │   ├── drivers_index.blade.php
│   │   ├── drivers_create.blade.php
│   │   ├── trips_index.blade.php
│   │   ├── trips_create.blade.php
│   │   ├── fuel_records.blade.php
│   │   ├── maintenance_records.blade.php
│   │   ├── maintenance_create.blade.php
│   │   └── traffic/
│   │       ├── dashboard.blade.php            ← Traffic overview
│   │       ├── analytics.blade.php            ← Analytics view
│   │       └── trip_analysis.blade.php        ← Trip analysis
│   └── css/
│       └── app.css
├── routes/
│   ├── web.php
│   └── console.php
├── SYSTEM_ARCHITECTURE.md                     ← Detailed documentation
├── TRAFFIC_SYSTEM_README.md
└── README.md
```

---

## 🔧 Configuration

### Database Configuration (.env)
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fleet_management_system
DB_USERNAME=root
DB_PASSWORD=
```

### Application Settings (config/app.php)
- Timezone: Detected from system
- Locale: en (English)
- Key: Generated via `php artisan key:generate`

---

## 📊 Data Flow Example

### GPS Data → Traffic Recommendations (~5 minute example)

**08:00:00 - Trip Starts**
- Driver leaves downtown terminal
- Vehicle ID: 1, Trip ID: 5
- Destination: Airport (25.5 km away)

**08:00:30 - GPS Point 1**
```
Location: [40.7128, -74.0060]
Speed: 60 km/h
Status: MODERATE congestion (🟡 yellow)
→ Stored in location_logs table
```

**08:05:00 - GPS Point 11**
```
Location: [40.7500, -74.0150]
Speed: 35 km/h
Status: SEVERE congestion (🔴 red)
→ Stored in location_logs table
→ Triggers TrafficData entry
```

**08:30:00 - GPS Point 61**
```
Location: [40.7800, -74.0200]
Speed: 25 km/h
Status: SEVERE congestion (🔴 red)
→ Identifies "Lincoln Tunnel" as congestion segment
→ Duration: 25 minutes (08:05 - 08:30)
```

**08:48:00 - Trip Completes**
```
POST /traffic/trips/5/analyze
→ TrafficAnalysisService::analyzeTripRoute()
→ Calculates:
   - Average speed: 42.3 km/h
   - Actual time: 48 minutes (vs 36 estimated)
   - 12 minutes delay due to traffic
→ Identifies 2 congestion segments
→ Generates 3 alternatives:
   1. "Via FDR Drive" - 8 min saved (78% confidence)
   2. "Via Queens Bridge" - 10 min saved (83% confidence)
   3. "Delayed start (off-peak)" - 6 min saved (71% confidence)
```

**08:49:00 - Driver Reviews Recommendations**
```
GET /traffic/trips/5/recommendations
→ Driver sees 3 options on dashboard
→ Accepts option 2: "Via Queens Bridge"
→ PATCH /traffic/recommendations/2/status
→ Status: accepted
→ Used for future route optimization
```

---

## 🧪 Testing Features

### Manual Testing Checklist
- [ ] Create vehicle and verify in database
- [ ] Add driver with all required fields
- [ ] Create trip linking vehicle and driver
- [ ] Submit GPS location data via API
- [ ] Verify congestion level calculated
- [ ] Complete trip and trigger analysis
- [ ] Check generated recommendations
- [ ] Accept/reject recommendation and verify status
- [ ] View dashboard KPI cards
- [ ] Check traffic hotspots

### Quick Test Queries
```sql
-- Check location logs
SELECT * FROM location_logs ORDER BY recorded_at DESC LIMIT 10;

-- Check traffic data
SELECT * FROM traffic_data WHERE congestion_level = 'severe';

-- Check route recommendations
SELECT * FROM route_recommendations WHERE status = 'pending';

-- Check recommendation adoption
SELECT status, COUNT(*) FROM route_recommendations GROUP BY status;
```

---

## 🚀 Performance Tips

1. **Database Indexes**: Automatically created for:
   - vehicle_id + recorded_at on location_logs
   - trip_id + recorded_at on traffic_data
   - status on route_recommendations

2. **Query Optimization**: Use eager loading
   ```php
   Trip::with('vehicle', 'driver', 'locationLogs')->get();
   ```

3. **Caching**: Cache frequent queries
   ```php
   Cache::remember('active_vehicles', 300, function() {
       return Vehicle::where('status', 'available')->count();
   });
   ```

4. **Asynchronous Processing**: Use queues for heavy analysis
   ```php
   dispatch(new AnalyzeTripJob($trip));
   ```

---

## 📚 Documentation Files

- **README.md** - This file (Quick start & overview)
- **SYSTEM_ARCHITECTURE.md** - Detailed architecture & design
- **TRAFFIC_SYSTEM_README.md** - Traffic system specifics
- **Code Comments** - Inline documentation in models/controllers

---

## 🔍 Troubleshooting

### Common Issues

**"Column not found" Error**
- Solution: Run missing migrations
  ```bash
  php artisan migrate
  ```

**GPS Data Not Appearing in Dashboard**
- Check vehicle_id exists in vehicles table
- Verify trip_id exists in trips table
- Ensure coordinates are valid (latitude: -180 to 180, longitude: -180 to 180)

**Recommendations Not Generating**
- Trip needs LocationLog data from GPS submissions
- Database should have route_analyses and route_recommendations tables
- Run `php artisan migrate` if tables missing

**Dashboard Shows No Data**
- Create at least 1 vehicle via `/vehicles/create`
- Create at least 1 driver via `/drivers/create`
- Create trip via `/trips/create`
- Submit GPS data via API to `/traffic/record-data`

---

## 📞 Support

For questions or issues:
1. Check SYSTEM_ARCHITECTURE.md for detailed information
2. Review code comments in models/controllers
3. Check Laravel documentation: https://laravel.com/docs

---

## 📝 License

Educational project for CSC 305 - Midterm Project (Spring 2026)

---

**Version**: 1.0  
**Last Updated**: March 19, 2026  
**Status**: ✅ Complete & Production Ready

Start by accessing: **http://localhost:8000/**
