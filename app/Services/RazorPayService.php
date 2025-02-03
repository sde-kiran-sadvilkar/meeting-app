<?php

namespace App\Services;

use App\Interfaces\TransactionFlow;
use App\Models\Subscription;
use App\Models\Transaction;
use App\Models\TransactionResponse;
use App\Models\User;
use Carbon\Carbon;

class RazorPayService implements TransactionFlow
{

    public function initiate(array $data)
    {

        $transaction = new Transaction($data);
        $transaction->save();

        $this->redirectToFateway($data);
    }

    public function redirectToFateway(array $data)
    {
        //Logic to redirect to gateway goes here



        //this handleCallback will be called from a route since this a callback from payment gateway
        //Just for demo calling it here directly to showcase the flow
        $this->handleCallback($data);
    }
    public function handleCallback(array $data)
    {

        $transaction = Transaction::where('name', $data['name'])->first();

        //Assuming that transaction is successful
        if ($transaction) {
            $transaction->status = 'SUCCESS';
            $transaction->save();

            $tranx_resp = new TransactionResponse();
            $tranx_resp->transaction_id = $transaction->id;
            $tranx_resp->response = json_encode($data);
            $tranx_resp->save();

            $this->createSubscription($data);
        }
    }
    public function createSubscription(array $data)
    {

        $subscription = new Subscription();
        $subscription->plan_name = $data['plan'];
        $subscription->user_id = $data['user_id'];
        $subscription->plan_id = $data['plan_id'];
        $subscription->plan_start_date = Carbon::now();
        $subscription->plan_end_date = Carbon::now()->addDays(30); //Setting end date to 30 days
        $subscription->is_expired = false;


        if ($subscription->save()) {
            $this->updateUser($data, $subscription);
        }
    }
    public function updateUser(array $data, $subscription)
    {

        $user = User::where('id', $data['user_id'])->first();
        $user->current_plan = $subscription->plan_name;
        $user->current_plan_expiry_at = $subscription->plan_end_date;
        $user->save();
    }
}
