<?php

namespace App\Models;

use App\Enums\AircraftLocationPilotStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AircraftLocationPilot extends Model
{
    //use HasFactory;

    protected $with = ['coupons'];
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

    public function coupons()
    {
        return $this->belongsToMany(Coupon::class, 'checkins', 'aircraft_location_pilot_id', 'coupon_id')->withPivot('status', 'created_at');
    }

    public function isChecked($coupon_id): bool
    {
        if ($this->coupons()->where('coupon_id', $coupon_id)->count()) {
            return true;
        }

        return false;
    }
}
