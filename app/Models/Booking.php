<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    public function scopeUpcoming($query, $tz = 'UTC')
    {
        $time = Carbon::now()->setTimezone($tz)->format('Y-m-d H:i:s');

        return $query->where('booking_date', '>', $time);
    }

    public function scopePast($query, $tz = 'UTC')
    {
        $time = Carbon::now()->setTimezone($tz)->format('Y-m-d H:i:s');

        return $query->where('booking_date', '<', $time);
    }
}
