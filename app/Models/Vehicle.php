<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = ['plate_number', 'make', 'model', 'type', 'status', 'capacity', 'last_maintenance_date', 'next_maintenance_date'];

    public function maintenanceRecords(){
        return $this->hasMany(MaintenanceRecord::class);
    }

    public function trips() {
        return $this->hasMany(Trip::class);
    }

    public function fuelRecords() {
        return $this->hasMany(FuelRecord::class);
    }

    public function assignments() {
        return $this->hasMany(Assignments::class);
    }

    public function trafficData() {
        return $this->hasMany(TrafficData::class);
    }

    public function locationLogs() {
        return $this->hasMany(LocationLog::class);
    }
}