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
    protected $guarded = ['children_coupon'];


    protected $casts = [
        'aircrafttype' => AircraftType::class,
        'status' => CouponStatus::class,
    ];

    public function tickettype(): BelongsTo
    {
        return $this->belongsTo(Tickettype::class);
    }
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /*
    //ez a scope amit ráhúzunk a resource-re
    public function scopeUnderProcess(Builder $query): void
    {
        $query->where('source', '=', 'Egyéb');
    }
    */

    public function parentCoupon()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function childrenCoupons()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }
}

