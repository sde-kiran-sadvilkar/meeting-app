<?php

namespace App\Services;

use Carbon\Carbon;

class TransactionService
{






    public function createTransaction($data, $userId, $gateway)
    {


        $data = $this->createDemoData($userId);

        if ($gateway == 'razor_pay') {

            (new RazorPayService())->initiate($data);
        }
    }



    private function createDemoData($userId): array
    {
        // return [];
        $trnxName = Carbon::now()->timestamp;

        $demoData = [

            'name' => $trnxName,
            'user_id' => $userId,
            'gateway_name' => 'razor_pay',
            'gateway_id' => 1,
            'gateway_trnx_id' => 'razor_pay_' . $trnxName,
            'rrn_number' => $trnxName,
            'amount' => 20,
            'plan' => 'advance_plan',
            'transaction_mode' => 'CC',
            'plan_id' => 1,
        ];


        return $demoData;
    }
}
