<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RouteRecommendation extends Model
{
    protected $fillable = [
        'route_analysis_id',
        'trip_id',
        'alternative_route',
        'estimated_time_saved',
        'actual_time_saved',
        'accepted_by_driver',
        'distance',
        'confidence_level',
        'status',
    ];

    protected $casts = [
        'estimated_time_saved' => 'float',
        'distance' => 'float',
        'confidence_level' => 'integer',
    ];

    /**
     * Get the route analysis that this recommendation belongs to
     */
    public function analysis(): BelongsTo
    {
        return $this->belongsTo(RouteAnalysis::class, 'route_analysis_id');
    }

    /**
     * Get the trip that this recommendation is for
     */
    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }
}
