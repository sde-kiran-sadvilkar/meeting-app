<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    //

    public function scopeUpcoming($query)
    {
        return $query->where('booking_date', '>', Carbon::now()->format('Y-m-d H:i:s'));
    }

    public function scopePast($query)
    {
        return $query->where('booking_date', '<', Carbon::now()->format('Y-m-d H:i:s'));
    }
}
