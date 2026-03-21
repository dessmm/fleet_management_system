<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FuelRecord extends Model
{
    protected $fillable = ['vehicle_id', 'fuel_type', 'quantity', 'price_per_liter', 'cost', 'date', 'odometer', 'gas_station', 'notes'];

    public function vehicle() {
        return $this->belongsTo(Vehicle::class);
    }
}
