<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    //use HasFactory;
    
    public function areatypes()
    {
        return $this->belongsTo(AreaType::class);
    }
    
}
