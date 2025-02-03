<?php

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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('plan_name', 255);
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('plan_id');
            $table->dateTime('plan_start_date');
            $table->dateTime('plan_end_date');
            $table->dateTime('transaction_id');
            $table->boolean('is_expired')->default(false);   // this can be update using schedular at midnight
            $table->timestamps();
            $table->softDeletes();


            $table->foreign('plan_id')->references('id')->on('subscription_packs')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');

            $table->index(['user_id', 'plan_id']);
            $table->index(['user_id', 'plan_start_date', 'plan_end_date']);
            $table->index(['user_id', 'transaction_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
