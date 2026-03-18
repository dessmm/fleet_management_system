<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignments extends Model
{
    protected $fillable = ['vehicle_id', 'driver_id', 'trip_id', 'status'];

    public function vehicle() {
        return $this->belongsTo(Vehicle::class);
    }

    public function driver() {
        return $this->belongsTo(Driver::class);
    }

    public function trip() {
        return $this->belongsTo(Trip::class);
    }
}
