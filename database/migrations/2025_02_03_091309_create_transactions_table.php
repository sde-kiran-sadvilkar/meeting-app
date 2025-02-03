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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 55)->unique();               //Readable Transaction name - TRN{DATE}{TIMESTAMP}
            $table->unsignedBigInteger('user_id');   //User Id
            $table->string('gateway_name', 55);     //Name of the gateway
            $table->string('gateway_id', 55);       //Gateway ID in case if we have multiple payment gateways
            $table->string('gateway_trnx_id', 55)->nullable();  //Transaction ID from the payment gateway
            $table->string('rrn_number', 55)->nullable();       // RRN number
            $table->float('amount');
            $table->string('plan', 50);                // Plan to which the user has subscribed
            $table->string('transaction_mode')->nullable();   //Credit,Debit, NEFT etc
            $table->enum('status', ['INITIATED', 'DECLINED', 'SUCCESS', 'FAILED', 'TIME_OUT', 'ERROR'])->default('INITIATED');
            $table->enum('disputed', ['YES', 'NO'])->default('NO');
            $table->enum('refunded', ['YES', 'NO'])->default('NO');
            $table->timestamps();
            $table->softDeletes();


            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->index(['user_id', 'status']);
            $table->index(['gateway_id', 'status']);

            //Entire response from Payment gateway is stored in a separate table transactions_response to reduced the size of this table and to increase speed.
            //Since the payment response will be json string

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
