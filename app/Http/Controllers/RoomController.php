<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;


use App\Services\BookingService;
use App\Services\RoomService;

class RoomController extends Controller
{
    //

    public function __construct(private RoomService $roomService) {}

    public function getMeetingRooms(Request $request)
    {

        $availableRooms = $this->roomService->getAvailableRooms(
            [
                'date' => $request->get('date'),
                'time' => $request->get('time'),
                'duration' => $request->get('duration'),
                'capacity' => $request->get('capacity')
            ]
        );

        return response()->json([
            'success' => true,
            'data' => $availableRooms
        ], 200);
    }
}
