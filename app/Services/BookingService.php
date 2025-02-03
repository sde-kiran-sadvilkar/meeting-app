<?php

namespace App\Services;

use App\Models\Booking;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class BookingService
{


    public function __construct(
        private RoomService $roomService,
        private UserService $userService,
        private SubscriptionPacktService $subscriptionPacktService
    ) {}




    public function createBooking(array $bookingData, int $userId): bool
    {


        $currentSubscription = $this->userService->getUserSubscription($userId);
        $canBook = $this->checkIfUserCanBook($userId, $currentSubscription);


        if ($canBook) {
            $booking = new Booking();
            $booking->name = $bookingData['name'];
            $booking->room_id = $bookingData['room_id'];
            $booking->user_id = $userId;
            $booking->booking_date = $bookingData['date'];
            $booking->booking_start_time =  $bookingData['date'];
            $booking->booking_end_time = Carbon::createFromFormat('Y-m-d H:i:s', $bookingData['date'], 'UTC')->addMinutes(intval($bookingData['duration']));
            $booking->booking_duration = $bookingData['duration'];

            return $booking->save();
        } else {
            return false;
        }
    }

    public function checkIfUserCanBook($userId, $currentSubscription)
    {

        $today = Carbon::today()->format('Y-m-d');
        $tomorrow = Carbon::tomorrow()->format('Y-m-d');

        $bookingsToday = Booking::where('user_id', $userId)->whereBetween('created_at', [$today, $tomorrow])->get()->count();

        $maxbooking = $this->subscriptionPacktService->getBookingLimit($currentSubscription);

        return ($bookingsToday < $maxbooking);
    }


    public function applyFilters($requestData): LengthAwarePaginator|null
    {

        $bookings = Booking::query();

        if (isset($requestData['filters'])) {

            $filters = $requestData['filters'];

            if (isset($filters['booking_date'])) {

                if ($filters['booking_date'] == 'upcoming') {

                    $bookings = $bookings->Upcoming('Asia/Kolkata');
                } else {
                    $bookings = $bookings->Past('Asia/Kolkata');
                }
            }
        } else {
            $bookings = $bookings->Upcoming();
        }

        return $bookings->paginate(config('system_config.pagination_length'));
    }
}
