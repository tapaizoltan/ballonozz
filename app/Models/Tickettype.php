<?php

namespace App\Models;

use App\Enums\TicketTypeVip;
use App\Enums\TicketTypePrivate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tickettype extends Model
{
    protected $casts = [
        'vip' => TicketTypeVip::class,
        'private' => TicketTypePrivate::class,
    ];

    //use HasFactory;
    
    public function aircrafts()
    {
        return $this->hasMany(Aircraft::class); // itt azt definiáltuk, hogy egy jegytípushoz több légijármű is tartozhat.
    }
}
