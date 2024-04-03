<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends Model
{
    //use HasFactory;
    
    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    use SoftDeletes;
}
