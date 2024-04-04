<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Region extends Model
{
    //use HasFactory;

    public function locations()
    {
        return $this->hasMany(Location::class);
    }
}
