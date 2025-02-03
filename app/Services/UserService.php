<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function getUserSubscription(string $userId): ?string
    {

        $plan = User::where('id', $userId)->select('current_plan')->first();

        if ($plan) {
            return $plan['current_plan'];
        }

        return null;
    }
}
