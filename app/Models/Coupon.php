<?php

namespace App\Models;

use App\Enums\AircraftType;
use App\Enums\CouponStatus;
use App\Models\Scopes\ClientScope;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;

#[ScopedBy([ClientScope::class])]

class Coupon extends Model
{
    //use HasFactory;
    protected $guarded = ['parent_id'];
    private $checkList = [];
    protected $casts = [
        'status' => CouponStatus::class,
        'aircraft_type' => AircraftType::class,
    ];

    public function passengers()
    {
        return $this->hasMany(Passenger::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function aircraftLocationPilots()
    {
        return $this->belongsToMany(AircraftLocationPilot::class, 'checkins', 'coupon_id', 'aircraft_location_pilot_id')->withPivot('status');
    }

    public function tickettype()
    {
        return $this->hasOne(Tickettype::class, 'id', 'tickettype_id');
    }

    private function validatePassengersData(self $coupon): void
    {
        foreach ($coupon->passengers as $p) {
            if ($p->firstname && $p->lastname && $p->date_of_birth && $p->id_card_number && $p->body_weight) {
                $this->checkList[] = true;
            } else {
                $this->checkList[] = false;
            }
        }
    }

    protected function isValid(): Attribute
    {
        return Attribute::make(
            get: function () {
                $noOneMissing = $this->membersCount == ($this->passengers->count() + $this->childrenCoupons?->map(fn ($coupon) => $coupon->passengers->count())->sum() ?? 0);
                
                $this->validatePassengersData($this);
                if ($this->childrenCoupons) {
                    $this->childrenCoupons->map(fn ($coupon) => $this->validatePassengersData($coupon));
                }

                return count(array_unique($this->checkList)) === 1 && $noOneMissing;
            },
        );
    }

    protected function isActive(): Attribute
    {
        return Attribute::make(
            get: function () {
                
                $isParent = $this->parent_id === null;

                if ($this->expiration_at > now() && in_array($this->status, [CouponStatus::CanBeUsed, CouponStatus::Gift]) && $isParent && $this->isValid) {
                    return true;
                }

                return false;
            },
        );
    }

    protected function missingData(): Attribute
    {
        return Attribute::make(
            get: fn () => in_array($this->status, [CouponStatus::CanBeUsed, CouponStatus::Gift]) && !$this->isValid,
        );
    }

    protected function isUsed(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (count($this->aircraftLocationPilots->where('pivot.status', 1))) {
                    return true;
                }
                return false;
            },
        );
    }    

    protected function membersCount(): Attribute
    {
        return Attribute::make(
            get: function () {

                $membersCount = $this->adult + $this->children;

                if ($this->childrenCoupons) {
                    return $membersCount + $this->childrenCoupons->map(fn ($coupon) => $coupon->adult + $coupon->children)->sum();
                }

                return $membersCount;
            },
        );
    }

    protected function membersBodyWeight(): Attribute
    {
        return Attribute::make(
            get: function () {

                $bodyWeight = $this->passengers->sum('body_weight');

                if ($this->childrenCoupons) {
                    return $bodyWeight + $this->childrenCoupons->map(fn ($coupon) => $coupon->passengers->sum('body_weight'))->sum();
                }

                return $bodyWeight;
            },
        );
    }

    public function parentCoupon()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function childrenCoupons()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }
}