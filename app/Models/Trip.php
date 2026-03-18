<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $fillable = ['start_location', 'end_location', 'start_time', 'end_time', 'distance', 'status', 'vehicle_id', 'driver_id'];

    public function vehicle() {
        return $this->belongsTo(Vehicle::class);
    }

    public function driver() {
        return $this->belongsTo(Driver::class);
    }
}
