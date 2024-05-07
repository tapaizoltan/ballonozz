<?php

namespace App\Models;

use App\Mail\EventDeleted;
use App\Enums\CouponStatus;
use App\Mail\EventExecuted;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Model;
use App\Enums\AircraftLocationPilotStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AircraftLocationPilot extends Model
{
    //use HasFactory;

    protected $guarded = [];

    protected $with = ['coupons'];
    protected $casts = [
        'status' => AircraftLocationPilotStatus::class,
    ];

    protected static function booted(): void
    {
        static::updated(function (self $event) {

            if ($event->status === AircraftLocationPilotStatus::Executed || $event->status === AircraftLocationPilotStatus::Deleted) {
                
                $checkedCoupons = array_filter($event->coupons->map(function ($coupon) {
                    
                    if ($coupon->pivot->status == 1) {
                        return $coupon->id;
                    }
                    
                    return null;

                })->toArray());

                switch ($event->status) {

                    # case AircraftLocationPilotStatus::Finalized: --> mail: App\Filament\Resources\AircraftLocationPilotResource\Pages\ListCheckins.php

                    case AircraftLocationPilotStatus::Executed:

                        Coupon::whereIn('id', $checkedCoupons)->whereNot('status', CouponStatus::Expired)->update(['status' => CouponStatus::Used]);
                        
                        foreach ($event->coupons as $coupon) {
                            Mail::to($coupon->user)->queue(new EventExecuted(
                                user:   $coupon->user,
                                coupon: $coupon,
                                event:  $event
                            ));
                        }
                        break;

                    case AircraftLocationPilotStatus::Deleted:
                        
                        Checkin::where('aircraft_location_pilot_id', $event->id)->whereIn('coupon_id', $checkedCoupons)->update(['status' => 0]);
                        
                        if ($event->getOriginal('status') !== AircraftLocationPilotStatus::Executed) {
                            foreach ($event->coupons as $coupon) {
                                Mail::to($coupon->user)->queue(new EventDeleted(
                                    user:   $coupon->user,
                                    coupon: $coupon,
                                    event:  $event
                                ));
                            }
                        }
                        break;
                }
            }
        });
    }

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

    public function tickettypes()
    {
        return $this->belongsToMany(Tickettype::class, 'aircraft_tickettype', 'aircraft_id', 'tickettype_id');
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

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    protected function dateTime(): Attribute
    {
        return Attribute::make(
            get: function () {
                $dateTime = $this->date . ' ' . $this->time;
                return Carbon::parse($dateTime)->translatedFormat('Y F d. H:i');
            },
        );
    }
}
