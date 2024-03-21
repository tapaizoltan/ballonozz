<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Passenger extends Model
{
    //use HasFactory;

    protected function fullname(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->lastname.' '.$this->firstname.' ('.$this->date_of_birth.')',
        );
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }
}
