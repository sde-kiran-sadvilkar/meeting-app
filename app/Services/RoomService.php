<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;

class RoomService
{
    public function getAvailableRooms(array $condition): ?Collection
    {

        $rooms = $this->getRoomsBasedOnCapacity($condition['capacity']);

        $booking_start_time = $condition['date'];
        $booking_end_time = Carbon::createFromFormat('Y-m-d H:i:s', $condition['date'], 'UTC')->addMinutes(intval($condition['duration']))->format('Y-m-d H:i:s');

        $nonAvailableRooms = Booking::where(function ($query) use ($booking_start_time, $booking_end_time) {
            $query->whereBetween('booking_start_time', [$booking_start_time, $booking_end_time])
                ->orwhereBetween('booking_end_time', [$booking_start_time, $booking_end_time]);
        })
            ->orwhere(function ($query) use ($booking_start_time, $booking_end_time) {

                $query->where('booking_start_time', '<=', $booking_start_time)
                    ->where('booking_end_time', '>=', $booking_end_time);
            })
            ->whereIn('room_id', $rooms)
            ->select('room_id')
            ->distinct()
            ->get()
            ->pluck('room_id');

        $availableRoomsId = array_diff($rooms->toArray(), $nonAvailableRooms->toArray());
        $availableRooms = $this->getRooms($availableRoomsId);

        return $availableRooms;
    }

    public function getRoomsBasedOnCapacity($capacity): Collection
    {

        return Room::where('capacity', '>=', $capacity)->get()->pluck('id');
    }

    public function getRooms(array $roomIds): Collection
    {
        return Room::whereIn('id', $roomIds)->get();
    }
}
