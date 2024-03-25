<?php

namespace App\Models;

use App\Enums\CouponStatus;
use App\Enums\CouponTypeVip;
use App\Enums\CouponTypePrivate;
use App\Models\Scopes\ClientScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;

#[ScopedBy([ClientScope::class])]
class Coupon extends Model
{
    //use HasFactory;

    protected $casts = [
        'status' => CouponStatus::class,
        'vip' => CouponTypeVip::class,
        'private' => CouponTypePrivate::class,
    ];

    public function passengers()
    {
        return $this->hasMany(Passenger::class);
    }

    public function ticketType()
    {
        return $this->hasOne(Tickettype::class, 'id', 'tickettype_id');
    }

    protected function isActive(): Attribute
    {
        return Attribute::make(
            get: function () {
                
                if (in_array($this->status, [CouponStatus::CanBeUsed, CouponStatus::Gift]) && ($this->adult + $this->children == $this->passengers->count())) {
                    return true;
                }

                return false;
            },
        );
    }
}