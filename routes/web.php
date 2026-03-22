<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\MaintenanceRecordController;
use App\Http\Controllers\FuelRecordController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\TrafficController;

Route::get('/', [HomeController::class, 'index']);

Route::resource('vehicles', VehicleController::class);
Route::resource('drivers', DriverController::class);
Route::resource('trips', TripController::class);
Route::patch('/trips/{trip}/status', [TripController::class, 'updateStatus'])->name('trips.update-status');
Route::get('/trips/{trip}/pdf', [TripController::class, 'exportPdf'])->name('trips.pdf');
Route::resource('maintenance_records', MaintenanceRecordController::class);
Route::get('/maintenance_records/{maintenance_record}/pdf', [MaintenanceRecordController::class, 'exportPdf'])->name('maintenance_records.pdf');
Route::patch('/maintenance_records/{maintenance_record}/complete', [MaintenanceRecordController::class, 'markComplete'])->name('maintenance_records.complete');
Route::resource('fuel_records', FuelRecordController::class);
Route::get('/fuel_records/{fuel_record}/pdf', [FuelRecordController::class, 'exportPdf'])->name('fuel_records.pdf');
Route::resource('assignments', AssignmentController::class);

Route::prefix('traffic')->name('traffic.')->group(function () {
    Route::get('dashboard', [TrafficController::class, 'dashboard'])->name('dashboard');
    Route::get('analytics', [TrafficController::class, 'analytics'])->name('analytics');
    Route::get('hotspots', [TrafficController::class, 'showHotspots'])->name('hotspots-view');
    Route::get('hotspots/json', [TrafficController::class, 'getCongestionHotspots'])->name('hotspots-json');
    Route::get('hotspots/data/{latitude}/{longitude}', [TrafficController::class, 'getHotspotData'])->name('hotspot-data');
    Route::post('record-data', [TrafficController::class, 'recordData'])->name('record-data');
    Route::get('active-status', [TrafficController::class, 'getActiveStatus'])->name('active-status');
    Route::get('congestion-hotspots', [TrafficController::class, 'getCongestionHotspots'])->name('hotspots');
    Route::get('vehicle/{vehicleId}/history', [TrafficController::class, 'getVehicleTrafficHistory'])->name('vehicle-history');
    Route::post('trips/{trip}/analyze', [TrafficController::class, 'analyzeTrip'])->name('analyze-trip');
    Route::get('trips/{trip}/analysis', [TrafficController::class, 'showAnalysis'])->name('show-analysis');
    Route::get('trips/{trip}/recommendations', [TrafficController::class, 'getRecommendations'])->name('recommendations');
    Route::patch('recommendations/{recommendation}/status', [TrafficController::class, 'updateRecommendationStatus'])->name('update-recommendation');
    Route::post('trips/{trip}/suggest-route', [TrafficController::class, 'suggestRoute'])->name('suggest-route');
});