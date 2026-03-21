<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $fillable = ['name', 'license_number', 'license_expiry_date', 'contact', 'status'];

    protected $casts = [
        'license_expiry_date' => 'date',
    ];

    public function trips() {
        return $this->hasMany(Trip::class);
    }

    public function assignments() {
        return $this->hasMany(Assignments::class);
    }
}
