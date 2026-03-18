<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FuelRecord extends Model
{
    protected $fillable = ['vehicle_id', 'fuel_type', 'quantity', 'cost', 'date'];

    public function vehicle() {
        return $this->belongsTo(Vehicle::class);
    }
}
