<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tickettype extends Model
{
    //use HasFactory;
    public function aircrafts()
    {
        return $this->hasMany(Aircraft::class); // itt azt definiáltuk, hogy egy jegytípushoz több légijármű is tartozhat.
    }
}
