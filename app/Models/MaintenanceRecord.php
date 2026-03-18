<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceRecord extends Model
{
    protected $fillable = ['vehicle_id', 'issue', 'service_date', 'cost', 'technician_name'];

    public function vehicle() {
        return $this->belongsTo(Vehicle::class);
    }
}
