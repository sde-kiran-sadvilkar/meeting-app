<?php

namespace App\Http\Controllers;

use App\Services\TransactionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    //
    public function __construct(private TransactionService $transactionService) {}

    public function subscribe(Request $request): JsonResponse
    {

        $this->transactionService->createTransaction($request->all(), $request->user()->id, 'razor_pay');

        return response()->json(
            [
                'data' => [
                    'success' => true,
                    'errors' => '',
                ],
            ],
            200
        );
    }
}
