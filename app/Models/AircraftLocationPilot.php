<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AircraftLocationPilot extends Model
{
    //use HasFactory;
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
