<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrafficData extends Model
{
    protected $fillable = [
        'vehicle_id',
        'trip_id',
        'latitude',
        'longitude',
        'speed',
        'heading',
        'timestamp',
        'congestion_level'
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'speed' => 'float',
        'timestamp' => 'datetime',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }
}
