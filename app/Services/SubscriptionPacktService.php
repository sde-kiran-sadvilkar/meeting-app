<?php

namespace App\Services;

use App\Models\SubscriptionPack;

class SubscriptionPacktService
{


    public function getBookingLimit($slug): string|null
    {
        $limit = SubscriptionPack::where('slug', $slug)->select('booking_limit')->first();

        if ($limit) {
            return $limit['booking_limit'];
        }

        return null;
    }
}
