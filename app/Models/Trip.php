<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $fillable = ['start_location', 'end_location', 'start_time', 'end_time', 'distance', 'status', 'vehicle_id', 'driver_id'];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function vehicle() {
        return $this->belongsTo(Vehicle::class);
    }

    public function driver() {
        return $this->belongsTo(Driver::class);
    }

    public function trafficData() {
        return $this->hasMany(TrafficData::class);
    }

    public function routeAnalysis() {
        return $this->hasOne(RouteAnalysis::class);
    }

    public function routeRecommendations() {
        return $this->hasMany(RouteRecommendation::class);
    }

    public function locationLogs() {
        return $this->hasMany(LocationLog::class);
    }
}
