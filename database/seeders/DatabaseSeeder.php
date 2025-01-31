<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\SubscriptionPack;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //User::factory(10)->create();

        User::factory()->create([
            'name' => 'John',
            'email' => 'john@example.com',
            'password' => 'password'
        ]);

        User::factory()->create([
            'name' => 'Sam',
            'email' => 'sam@example.com',
            'password' => 'password'
        ]);

        User::factory()->create([
            'name' => 'Adam',
            'email' => 'adam@example.com',
            'password' => 'password'
        ]);

        $roomData = [
            [
                'name' => 'Meeting Room 1',
                'capacity' => 3
            ],
            [
                'name' => 'Meeting Room 2',
                'capacity' => 10
            ],
            [
                'name' => 'Meeting Room 3',
                'capacity' => 15
            ],
            [
                'name' => 'Meeting Room 4',
                'capacity' => 2
            ],
            [
                'name' => 'Meeting Room 5',
                'capacity' => 1
            ],
        ];


        foreach ($roomData as $room) {
            Room::factory()->create($room);
        }



        $planData = [
            [
                'name' => 'Basic Plan',
                'booking_limit' => 5,
                'slug' => 'basic_plan'
            ],
            [
                'name' => 'Advance Plan',
                'booking_limit' => 7,
                'slug' => 'advance_plan'
            ],
            [
                'name' => 'Premium Plan',
                'booking_limit' => 10,
                'slug' => 'premium_plan'
            ],
            [
                'name' => 'Free',
                'booking_limit' => 3,
                'slug' => 'free_plan'
            ]
        ];


        foreach ($planData as $plan) {
            SubscriptionPack::factory()->create($plan);
        }
    }
}
