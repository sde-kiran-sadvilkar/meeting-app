<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RoomController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/login', [LoginController::class, 'login']);
Route::post('/get-meeting-rooms', [RoomController::class, 'getMeetingRooms']);
Route::post('/create-booking', [BookingController::class, 'createBooking'])->middleware('auth:sanctum');
Route::get('/get-user-booking', [BookingController::class, 'getUserBookings'])->middleware('auth:sanctum');
