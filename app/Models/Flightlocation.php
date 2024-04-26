<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flightlocation extends Model
{
    use HasFactory;
    protected $table = 'locations';

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}
