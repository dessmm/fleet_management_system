<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceRecord extends Model
{
    protected $fillable = [
        'vehicle_id',
        'issue',
        'service_date',
        'cost',
        'technician_name',
        'completed_at',
    ];

    protected $casts = [
        'service_date' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function isCompleted(): bool
    {
        return !is_null($this->completed_at);
    }
}