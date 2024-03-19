<?php

namespace App\Models;

use App\Enums\CouponStatus;
use App\Enums\CouponTypeVip;
use App\Enums\CouponTypePrivate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coupon extends Model
{
    use HasFactory;

    protected $casts = [
        'status' => CouponStatus::class,
        'vip' => CouponTypeVip::class,
        'private' => CouponTypePrivate::class,
    ];
}
