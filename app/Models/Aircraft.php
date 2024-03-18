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
}
