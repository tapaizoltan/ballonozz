<?php

namespace App\Models;

use App\Enums\AircraftType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aircraft extends Model
{
    protected $casts = [
        'type' => AircraftType::class,
    ];

    use HasFactory;
    
    use SoftDeletes;

    //légijármű selector szabályrendszer
    public static function flyable($passenger_count, $vip_flag, $private_flag)
    {
        return self::where(function ($q) use ($passenger_count) {
            $q->where('unlimited', '=', 1)->orWhere('number_of_person', '>=', $passenger_count);
        })->where('vip', '=', $vip_flag)->where('private', '=', $private_flag)->get();
    }
}