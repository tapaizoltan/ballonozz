<?php

namespace App\Models;

use App\Enums\CouponStatus;
use App\Enums\CouponTypeVip;
use App\Enums\CouponTypePrivate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pendingcoupon extends Model
{
    use HasFactory;
    protected $table = 'coupons';

    protected $casts = [
        'status' => CouponStatus::class,
        'vip' => CouponTypeVip::class,
        'private' => CouponTypePrivate::class,
    ];

    public function scopeUnderProcess(Builder $query): void
    {
        $query->where('source', '=', 'Egyéb');
    }
}

