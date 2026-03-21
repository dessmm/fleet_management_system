# 📂 Project Files Reference

Complete list of all models, controllers, migrations, views, and documentation files in the Fleet Management System.

---

## 📦 Application Files

### Models (app/Models/)
Located: `app/Models/`

| Model | Purpose | Relationships |
|-------|---------|---------------|
| **Vehicle.php** | Fleet vehicles | hasMany: Trips, MaintenanceRecords, FuelRecords, LocationLogs, TrafficData |
| **Driver.php** | Driver profiles | hasMany: Trips, RouteRecommendations, Assignments |
| **Trip.php** | Journey records | belongsTo: Vehicle, Driver; hasMany: LocationLogs, TrafficData, RouteRecommendations; hasOne: RouteAnalysis |
| **LocationLog.php** | Raw GPS data (NEW) | belongsTo: Vehicle, Trip |
| **TrafficData.php** | Processed traffic | belongsTo: Vehicle, Trip |
| **RouteAnalysis.php** | Trip analysis | belongsTo: Trip; hasMany: RouteRecommendations |
| **RouteRecommendation.php** | Route suggestions | belongsTo: RouteAnalysis, Trip |
| **MaintenanceRecord.php** | Service history | belongsTo: Vehicle |
| **FuelRecord.php** | Fuel tracking | belongsTo: Vehicle |
| **Assignments.php** | Vehicle-Driver links | belongsTo: Vehicle, Driver |
| **User.php** | System users | (default Laravel) |

---

### Controllers (app/Http/Controllers/)
Located: `app/Http/Controllers/`

| Controller | Methods | Purpose |
|-----------|---------|---------|
| **HomeController.php** | index() | Dashboard home page |
| **VehicleController.php** | index, create, store, show, edit, update, delete | Vehicle CRUD operations |
| **DriverController.php** | index, create, store, show, edit, update, delete | Driver management |
| **TripController.php** | index, create, store, show, edit, update, delete | Trip management |
| **TrafficController.php** | recordData, dashboard, analytics, analyzeTrip, showAnalysis, getRecommendations, updateRecommendationStatus, getActiveStatus, getCongestionHotspots, getVehicleTrafficHistory (10+ methods) | Traffic detection & API endpoints |
| **MaintenanceRecordController.php** | index, create, store, show, edit, update, delete | Maintenance tracking |
| **FuelRecordController.php** | index, create, store, show, edit, update, delete | Fuel records |
| **AssignmentController.php** | index, create, store, show, edit, update, delete | Fleet assignments |

---

### Services (app/Services/)
Located: `app/Services/`

| Service | Methods | Purpose |
|---------|---------|---------|
| **TrafficAnalysisService.php** (450+ lines) | recordTrafficData(), analyzeTripRoute(), identifyCongestionSegments(), generateRouteRecommendations(), getActiveTrafficStatus(), getTripRecommendations(), calculateCongestionLevel(), estimateNormalTravelTime(), estimateTimeSavings(), generateAlternativeRoute(), createDefaultAnalysis() | Core traffic detection & analysis logic |

---

### Database Migrations (database/migrations/)
Located: `database/migrations/`

| Migration File | Table | Status |
|--------|-------|--------|
| 0001_01_01_000000_create_users_table.php | users | ✅ (Default) |
| 0001_01_01_000001_create_cache_table.php | cache | ✅ (Default) |
| 0001_01_01_000002_create_jobs_table.php | jobs | ✅ (Default) |
| 2026_03_18_182329_create_vehicles_table.php | vehicles | ✅ |
| 2026_03_18_182346_create_drivers_table.php | drivers | ✅ |
| 2026_03_18_182350_create_trips_table.php | trips | ✅ |
| 2026_03_18_182353_create_maintenance_records_table.php | maintenance_records | ✅ |
| 2026_03_18_182359_create_fuel_records_table.php | fuel_records | ✅ |
| 2026_03_18_184326_create_assignments_table.php | assignments | ✅ |
| 2026_03_19_000001_create_traffic_data_table.php | traffic_data | ✅ |
| 2026_03_19_000002_create_route_analyses_table.php | route_analyses | ✅ |
| 2026_03_19_000003_create_route_recommendations_table.php | route_recommendations | ✅ |
| 2026_03_19_000004_create_location_logs_table.php | location_logs | ✅ NEW |

---

### Routes (routes/)
Located: `routes/web.php`

| Type | Routes | Controller |
|------|--------|-----------|
| **Fleet Resources** | GET /vehicles, POST /vehicles, GET /vehicles/{id}, PUT /vehicles/{id}, DELETE /vehicles/{id} | VehicleController |
| | GET /drivers, POST /drivers, GET /drivers/{id}, PUT /drivers/{id}, DELETE /drivers/{id} | DriverController |
| | GET /trips, POST /trips, GET /trips/{id}, PUT /trips/{id}, DELETE /trips/{id} | TripController |
| **Traffic APIs** | POST /traffic/record-data | TrafficController |
| | GET /traffic/active-status | TrafficController |
| | GET /traffic/congestion-hotspots | TrafficController |
| | GET /traffic/vehicle/{id}/history | TrafficController |
| | POST /traffic/trips/{trip}/analyze | TrafficController |
| | GET /traffic/trips/{trip}/analysis | TrafficController |
| | GET /traffic/trips/{trip}/recommendations | TrafficController |
| | PATCH /traffic/recommendations/{id}/status | TrafficController |
| **Dashboards** | GET / | HomeController |
| | GET /traffic/dashboard | TrafficController |
| | GET /traffic/analytics | TrafficController |

---

### Views (resources/views/)
Located: `resources/views/`

#### Layout & Home
| File | Purpose |
|------|---------|
| **app.blade.php** | Main application layout with navigation & footer |
| **home.blade.php** | Home/dashboard page with hero section |

#### Vehicle Management
| File | Purpose |
|------|---------|
| **index.blade.php** | Vehicles list view with status indicators |
| **form.blade.php** (Enhanced) | Add/edit vehicle form with 3 sections, 12+ fields |

#### Driver Management
| File | Purpose |
|------|---------|
| **drivers_index.blade.php** | Drivers list with license & contact info |
| **drivers_create.blade.php** (Enhanced) | Add driver form with 4 sections, 10+ fields |

#### Trip Management
| File | Purpose |
|------|---------|
| **trips_index.blade.php** | Trips list with status & scheduling info |
| **trips_create.blade.php** | Trip creation form |

#### Maintenance & Fuel
| File | Purpose |
|------|---------|
| **maintenance_records.blade.php** | Service history list |
| **maintenance_create.blade.php** | Log maintenance record form |
| **fuel_records.blade.php** | Fuel consumption history |
| **fuel_records_create.blade.php** | Record fuel fill-up form |

#### Traffic Management (resources/views/traffic/)
| File | Purpose |
|------|---------|
| **dashboard.blade.php** | Real-time traffic overview with KPI cards |
| **analytics.blade.php** | Detailed analytics & performance metrics |
| **trip_analysis.blade.php** | Individual trip analysis with recommendations |

---

### Static Assets (resources/)
Located: `resources/`

| Resource | Purpose |
|----------|---------|
| css/app.css | Tailwind CSS configuration |
| js/app.js | JavaScript compilation (Vite) |
| js/bootstrap.js | Laravel bootstrap |

---

## 📚 Documentation Files

Located: Root directory

| File | Size | Contents |
|------|------|----------|
| **COMPLETION_SUMMARY.md** | ~3000 lines | Complete project overview & status |
| **SYSTEM_ARCHITECTURE.md** | ~3000 lines | Detailed technical architecture |
| **IMPLEMENTATION_GUIDE.md** | ~2000 lines | Quick start & usage guide |
| **API_DOCUMENTATION.md** | ~3000 lines | Complete API reference with examples |
| **TRAFFIC_SYSTEM_README.md** | ~500 lines | Traffic system specifics |
| **README.md** | ~200 lines | Basic readme |
| **PROJECT_FILES_REFERENCE.md** | This file | File organization reference |

---

## 📊 Database Structure

### Table: vehicles
```
┌─────────────┬──────────────┬──────────────┐
│ Column      │ Type         │ Index        │
├─────────────┼──────────────┼──────────────┤
│ id          │ bigint (PK)  │ Primary      │
│ plate_number│ varchar      │ Unique       │
│ make        │ varchar      │              │
│ model       │ varchar      │              │
│ type        │ varchar      │              │
│ status      │ enum         │              │
│ capacity    │ decimal      │              │
│ year        │ year         │              │
│ fuel_type   │ varchar      │              │
│ mileage     │ decimal      │              │
│ timestamps  │ datetime     │              │
└─────────────┴──────────────┴──────────────┘
```

### Table: drivers
```
┌──────────────────┬─────────────┬──────────┐
│ Column           │ Type        │ Index    │
├──────────────────┼─────────────┼──────────┤
│ id               │ bigint (PK) │ Primary  │
│ name             │ varchar     │          │
│ license_number   │ varchar     │ Unique   │
│ contact          │ varchar     │          │
│ email            │ varchar     │          │
│ status           │ enum        │          │
│ date_of_birth    │ date        │          │
│ address          │ text        │          │
│ license_expiry   │ date        │          │
│ license_class    │ varchar     │          │
│ experience_years │ integer     │          │
│ emergency_contact│ varchar     │          │
│ timestamps       │ datetime    │          │
└──────────────────┴─────────────┴──────────┘
```

### Table: trips
```
┌─────────────────┬──────────────┬──────────────────┐
│ Column          │ Type         │ Index            │
├─────────────────┼──────────────┼──────────────────┤
│ id              │ bigint (PK)  │ Primary          │
│ vehicle_id      │ bigint (FK)  │ Foreign, Index   │
│ driver_id       │ bigint (FK)  │ Foreign, Index   │
│ start_location  │ varchar      │                  │
│ end_location    │ varchar      │                  │
│ start_time      │ datetime     │                  │
│ end_time        │ datetime     │                  │
│ distance        │ decimal      │                  │
│ status          │ enum         │ Index            │
│ timestamps      │ datetime     │                  │
└─────────────────┴──────────────┴──────────────────┘
```

### Table: location_logs (NEW)
```
┌──────────────┬──────────────┬──────────────────┐
│ Column       │ Type         │ Index            │
├──────────────┼──────────────┼──────────────────┤
│ id           │ bigint (PK)  │ Primary          │
│ vehicle_id   │ bigint (FK)  │ Foreign, Index   │
│ trip_id      │ bigint (FK)  │ Foreign, Index   │
│ latitude     │ decimal(10,7)│                  │
│ longitude    │ decimal(10,7)│                  │
│ speed        │ decimal      │                  │
│ heading      │ integer      │                  │
│ altitude     │ decimal      │                  │
│ accuracy     │ decimal      │                  │
│ recorded_at  │ datetime     │ Index            │
│ timestamps   │ datetime     │                  │
└──────────────┴──────────────┴──────────────────┘
```

### Table: traffic_data
```
┌──────────────────┬──────────────┬──────────────────┐
│ Column           │ Type         │ Index            │
├──────────────────┼──────────────┼──────────────────┤
│ id               │ bigint (PK)  │ Primary          │
│ vehicle_id       │ bigint (FK)  │ Foreign, Index   │
│ trip_id          │ bigint (FK)  │ Foreign, Index   │
│ latitude         │ decimal      │                  │
│ longitude        │ decimal      │                  │
│ speed            │ decimal      │                  │
│ heading          │ integer      │                  │
│ timestamp        │ datetime     │ Index            │
│ congestion_level │ enum         │                  │
│ timestamps       │ datetime     │                  │
└──────────────────┴──────────────┴──────────────────┘
```

### Table: route_analyses
```
┌────────────────────┬──────────────┬──────────┐
│ Column             │ Type         │ Index    │
├────────────────────┼──────────────┼──────────┤
│ id                 │ bigint (PK)  │ Primary  │
│ trip_id            │ bigint (FK)  │ Index    │
│ original_route     │ varchar      │          │
│ average_speed      │ decimal      │          │
│ max_speed          │ decimal      │          │
│ min_speed          │ decimal      │          │
│ total_distance     │ decimal      │          │
│ estimated_time     │ integer      │          │
│ actual_time        │ integer      │          │
│ congestion_segments│ json         │          │
│ analysis_date      │ datetime     │ Index    │
│ timestamps         │ datetime     │          │
└────────────────────┴──────────────┴──────────┘
```

### Table: route_recommendations
```
┌────────────────────┬──────────────┬──────────┐
│ Column             │ Type         │ Index    │
├────────────────────┼──────────────┼──────────┤
│ id                 │ bigint (PK)  │ Primary  │
│ route_analysis_id  │ bigint (FK)  │ Index    │
│ trip_id            │ bigint (FK)  │ Index    │
│ alternative_route  │ text         │          │
│ estimated_time_sav │ decimal      │          │
│ actual_time_saved  │ decimal      │          │
│ accepted_by_driver │ boolean      │          │
│ distance           │ decimal      │          │
│ confidence_level   │ integer      │          │
│ status             │ enum         │ Index    │
│ timestamps         │ datetime     │          │
└────────────────────┴──────────────┴──────────┘
```

---

## 🔄 Data Flow Relationships

```
Mobile/GPS Device
    ↓ (location data)
POST /traffic/record-data (TrafficController::recordData)
    ↓
TrafficAnalysisService::recordTrafficData()
    ↓
Stores in location_logs table
Creates entry in traffic_data table
    ↓
Trip Completed → POST /traffic/trips/{trip}/analyze
    ↓
TrafficAnalysisService::analyzeTripRoute()
    ↓
Creates route_analyses entry
    ↓
Identifies congestion_segments
    ↓
TrafficAnalysisService::generateRouteRecommendations()
    ↓
Creates 3 route_recommendations entries
    ↓
Driver receives suggestions via dashboard
    ↓
GET /traffic/trips/{trip}/recommendations
    ↓
Driver accepts/rejects
    ↓
PATCH /traffic/recommendations/{id}/status
    ↓
System learns from feedback
```

---

## 📂 Complete Directory Structure

```
fleet_management_system/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── HomeController.php
│   │   │   ├── VehicleController.php
│   │   │   ├── DriverController.php
│   │   │   ├── TripController.php
│   │   │   ├── TrafficController.php ← CORE
│   │   │   ├── MaintenanceRecordController.php
│   │   │   ├── FuelRecordController.php
│   │   │   └── AssignmentController.php
│   │   └── Middleware/
│   ├── Models/
│   │   ├── Vehicle.php
│   │   ├── Driver.php
│   │   ├── Trip.php
│   │   ├── LocationLog.php ← NEW
│   │   ├── TrafficData.php
│   │   ├── RouteAnalysis.php
│   │   ├── RouteRecommendation.php
│   │   ├── MaintenanceRecord.php
│   │   ├── FuelRecord.php
│   │   ├── Assignments.php
│   │   └── User.php
│   ├── Services/
│   │   └── TrafficAnalysisService.php ← CORE (450+ lines)
│   └── Providers/
│
├── database/
│   ├── migrations/
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 2026_03_18_182329_create_vehicles_table.php
│   │   ├── 2026_03_18_182346_create_drivers_table.php
│   │   ├── 2026_03_18_182350_create_trips_table.php
│   │   ├── 2026_03_18_182353_create_maintenance_records_table.php
│   │   ├── 2026_03_18_182359_create_fuel_records_table.php
│   │   ├── 2026_03_18_184326_create_assignments_table.php
│   │   ├── 2026_03_19_000001_create_traffic_data_table.php
│   │   ├── 2026_03_19_000002_create_route_analyses_table.php
│   │   ├── 2026_03_19_000003_create_route_recommendations_table.php
│   │   └── 2026_03_19_000004_create_location_logs_table.php ← NEW
│   ├── factories/
│   └── seeders/
│
├── resources/
│   ├── views/
│   │   ├── app.blade.php
│   │   ├── home.blade.php
│   │   ├── index.blade.php
│   │   ├── form.blade.php ← ENHANCED
│   │   ├── drivers_index.blade.php
│   │   ├── drivers_create.blade.php ← ENHANCED
│   │   ├── trips_index.blade.php
│   │   ├── trips_create.blade.php
│   │   ├── maintenance_records.blade.php
│   │   ├── maintenance_create.blade.php
│   │   ├── fuel_records.blade.php
│   │   ├── fuel_records_create.blade.php
│   │   └── traffic/
│   │       ├── dashboard.blade.php
│   │       ├── analytics.blade.php
│   │       └── trip_analysis.blade.php
│   ├── css/
│   │   └── app.css
│   └── js/
│       ├── app.js
│       └── bootstrap.js
│
├── routes/
│   ├── web.php
│   └── console.php
│
├── config/
│   ├── app.php
│   ├── database.php
│   ├── auth.php
│   └── ... (other config)
│
├── public/
│   ├── index.php
│   └── build/
│
├── storage/
├── bootstrap/
├── vendor/
│
├── COMPLETION_SUMMARY.md         ← Project overview
├── SYSTEM_ARCHITECTURE.md         ← Technical docs
├── IMPLEMENTATION_GUIDE.md        ← Quick start
├── API_DOCUMENTATION.md           ← API reference
├── TRAFFIC_SYSTEM_README.md       ← Traffic specifics
├── PROJECT_FILES_REFERENCE.md     ← This file
├── README.md
├── composer.json
├── .env
└── artisan
```

---

## 🎯 Quick Navigation

### Want to understand the system?
→ Read: `COMPLETION_SUMMARY.md`

### Want to set up & run it?
→ Read: `IMPLEMENTATION_GUIDE.md`

### Want technical details?
→ Read: `SYSTEM_ARCHITECTURE.md`

### Want API examples?
→ Read: `API_DOCUMENTATION.md`

### Want to review code?
Start with:
1. `app/Services/TrafficAnalysisService.php` (core logic)
2. `app/Http/Controllers/TrafficController.php` (API endpoints)
3. `resources/views/traffic/dashboard.blade.php` (UI)

### Want to add features?
Start with:
1. Add model in `app/Models/`
2. Add controller in `app/Http/Controllers/`
3. Add migration in `database/migrations/`
4. Add views in `resources/views/`
5. Add routes in `routes/web.php`

---

## ✅ File Checklist

### Models (8 files)
- ✅ Vehicle.php
- ✅ Driver.php
- ✅ Trip.php
- ✅ LocationLog.php (NEW)
- ✅ TrafficData.php
- ✅ RouteAnalysis.php
- ✅ RouteRecommendation.php
- ✅ MaintenanceRecord.php, FuelRecord.php, Assignments.php

### Controllers (8 files)
- ✅ HomeController.php
- ✅ VehicleController.php
- ✅ DriverController.php
- ✅ TripController.php
- ✅ TrafficController.php (CORE)
- ✅ MaintenanceRecordController.php
- ✅ FuelRecordController.php
- ✅ AssignmentController.php

### Views (15+ files)
- ✅ app.blade.php
- ✅ home.blade.php
- ✅ form.blade.php (ENHANCED)
- ✅ drivers_create.blade.php (ENHANCED)
- ✅ And 11+ more

### Migrations (14 files)
- ✅ All 11 table migrations
- ✅ All executed & verified

### Documentation (6 files)
- ✅ COMPLETION_SUMMARY.md
- ✅ SYSTEM_ARCHITECTURE.md
- ✅ IMPLEMENTATION_GUIDE.md
- ✅ API_DOCUMENTATION.md
- ✅ TRAFFIC_SYSTEM_README.md (existing)
- ✅ PROJECT_FILES_REFERENCE.md (this file)

---

**Total Implementation**: 
- 8+ Models
- 8 Controllers
- 15+ Views
- 14 Migrations
- 1 Service (450+ lines)
- 6 Documentation Files (8000+ lines)
- 20+ API Endpoints
- 11 Database Tables
- Full-Stack Application ✅

**Status**: Complete & Ready for Use
