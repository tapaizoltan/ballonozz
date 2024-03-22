<?php

namespace App\Models;

use App\Enums\CouponStatus;
use App\Enums\CouponTypeVip;
use App\Enums\CouponTypePrivate;
use Illuminate\Database\Eloquent\Model;

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
}