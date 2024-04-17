<?php

namespace App\Models;

use App\Enums\AircraftType;
use App\Enums\CouponStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
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

    public function couponStatusExpired(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->expiration_at < now()) {
                    return CouponStatus::Expired;
                }
            },
        );
    }

    /*
    //ez a scope amit ráhúzunk a resource-re
    public function scopeUnderProcess(Builder $query): void
    {
        $query->where('source', '=', 'Egyéb');
    }
    */
}

