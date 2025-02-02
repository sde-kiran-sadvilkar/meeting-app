<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;


use App\Services\BookingService;
use App\Services\RoomService;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{
    //

    public function __construct(private RoomService $roomService) {}

    public function getMeetingRooms(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'date' => 'required',
            'duration' => 'required',
            'capacity' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'data' => [
                        'success' => false,
                        'errors' => $validator->errors()
                    ]
                ],
                422
            );
        }


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
