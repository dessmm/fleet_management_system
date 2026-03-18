<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\MaintenanceRecordController;
use App\Http\Controllers\FuelRecordController;
use App\Http\Controllers\AssignmentController;

Route::get('/', [HomeController::class, 'index']);

Route::resource('vehicles', VehicleController::class);
Route::resource('drivers', DriverController::class);
Route::resource('trips', TripController::class);
Route::resource('maintenance_records', MaintenanceRecordController::class);
Route::resource('fuel_records', FuelRecordController::class);
Route::resource('assignments', AssignmentController::class);
