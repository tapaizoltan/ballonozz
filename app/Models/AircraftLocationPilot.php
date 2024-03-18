<?php

namespace App\Models;

use App\Enums\AircraftLocationPilotStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AircraftLocationPilot extends Model
{
    //use HasFactory;
    protected $casts = [
        'status' => AircraftLocationPilotStatus::class,
    ];

    public function aircraft()
    {
        return $this->belongsTo(Aircraft::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
    
    public function pilot()
    {
        return $this->belongsTo(Pilot::class);
    }

}
