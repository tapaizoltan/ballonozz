<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Region extends Model
{
    public function locations()
    {
        return $this->hasMany(Location::class);
    }

    public function tickettypes(): BelongsToMany
    {
        return $this->belongsToMany(Tickettype::class, 'tickettype_region');
    }
}
