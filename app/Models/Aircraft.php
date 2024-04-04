<?php

namespace App\Models;

use App\Enums\AircraftType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Aircraft extends Model
{
    protected $casts = [
        'type' => AircraftType::class,
    ];

    use HasFactory;
    
    use SoftDeletes;

    public function tickettypes(): BelongsToMany
    {
        return $this->belongsToMany(Tickettype::class, 'aircraft_tickettype');
    }

    //légijármű selector szabályrendszer
    public static function flyable($passenger_count, $tickettype_id)
    {
        return self::Where('number_of_person', '>=', $passenger_count)->where('type', $tickettype_id)->get();
    }
}