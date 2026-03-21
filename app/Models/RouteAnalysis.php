<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RouteAnalysis extends Model
{
    protected $fillable = [
        'trip_id',
        'original_route',
        'average_speed',
        'max_speed',
        'min_speed',
        'total_distance',
        'estimated_time',
        'actual_time',
        'congestion_segments',
        'analysis_date',
    ];

    protected $casts = [
        'average_speed' => 'float',
        'max_speed' => 'float',
        'min_speed' => 'float',
        'total_distance' => 'float',
        'estimated_time' => 'integer',
        'actual_time' => 'integer',
        'congestion_segments' => 'array',
        'analysis_date' => 'datetime',
    ];

    /**
     * Get the trip that this analysis belongs to
     */
    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }

    /**
     * Get the route recommendations for this analysis
     */
    public function recommendations(): HasMany
    {
        return $this->hasMany(RouteRecommendation::class);
    }
}
