<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SignUpController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [LoginController::class, 'login']);
Route::post('/signup', [SignUpController::class, 'signup']);

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::post('/get-meeting-rooms', [RoomController::class, 'getMeetingRooms']);
    Route::post('/create-booking', [BookingController::class, 'createBooking']);
    Route::get('/get-user-booking', [BookingController::class, 'getUserBookings']);
    Route::post('/subscribe', [TransactionController::class, 'subscribe']);
});
