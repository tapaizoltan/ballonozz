<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends Model
{
    //use HasFactory;
    
    public function areatypes()
    {
        return $this->belongsTo(AreaType::class);
    }

    use SoftDeletes;
    
}
