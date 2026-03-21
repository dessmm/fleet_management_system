<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LocationLog extends Model
{
    protected $fillable = [
        'vehicle_id',
        'trip_id',
        'latitude',
        'longitude',
        'speed',
        'heading',
        'altitude',
        'accuracy',
        'recorded_at',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'speed' => 'float',
        'altitude' => 'float',
        'accuracy' => 'float',
        'recorded_at' => 'datetime',
    ];

    /**
     * Get the vehicle that this location log belongs to
     */
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * Get the trip that this location log belongs to
     */
    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }
}
