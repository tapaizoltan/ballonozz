<?php

namespace App\Models;

use App\Enums\AircraftType;
use App\Enums\CouponStatus;
use App\Enums\CouponTypeVip;
use App\Enums\CouponTypePrivate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pendingcoupon extends Model
{
    use HasFactory;
    protected $table = 'coupons';

    protected $casts = [
        'aircrafttype' => AircraftType::class,
        'status' => CouponStatus::class,
    ];

    public function tickettype(): BelongsTo
    {
        return $this->belongsTo(Tickettype::class);
    }

    public function scopeUnderProcess(Builder $query): void
    {
        $query->where('source', '=', 'Egyéb');
    }
}

