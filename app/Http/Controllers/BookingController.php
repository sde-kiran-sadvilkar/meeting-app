<?php

namespace App\Http\Controllers;

use App\Services\BookingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class BookingController extends Controller
{
    //

    public function __construct(private BookingService $bookingService) {}

    public function createBooking(Request $request): JsonResponse
    {

        // validation goes here

        $booking = $this->bookingService->createBooking($request->all(), $request->user()->id);

        if ($booking) {
            return response()->json([
                'success' => true,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'data' => [
                    'msg' => 'Please upgrade your plan to book more meetings',
                ],
            ], 200);
        }
    }

    public function getUserBookings(Request $request)
    {

        $bookings = $this->bookingService->applyFilters($request->all());

        return response()->json([
            'success' => true,
            'data' => [
                'bookings' => $bookings,
            ],
        ], 200);
    }

    public function getBookingSlots() {}
}
