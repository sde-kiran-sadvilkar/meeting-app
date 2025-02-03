<?php

namespace App\Http\Controllers;

use App\Services\TransactionService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    //
    public function __construct(private TransactionService $transactionService) {}


    public function subscribe(Request $request)
    {

        $this->transactionService->createTransaction($request->all(), $request->user()->id, 'razor_pay');
    }
}
