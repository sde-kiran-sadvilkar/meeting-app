<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            $table->string('name', 255);
            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('room_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
            $table->dateTime('booking_date');
            $table->dateTime('booking_start_time');
            //$table->dateTimeTz('booking_date_tz')->nullable(true)->default(null); //future reference when dealing with different timezone bookings
            $table->dateTime('booking_end_time');
            $table->smallInteger('booking_duration')->comment('duration of booking in minutes');
            $table->boolean('is_expired')->default(false); // This column can be used to process querey faster when dealing with checking of room availability
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
