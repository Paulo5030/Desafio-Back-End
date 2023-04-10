<?php

namespace App\Http\Controllers\Transactions;

use App\Http\Controllers\Controller;
use App\Service\TransactionService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class TransactionsController extends Controller
{
    private TransactionService $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    /**
     * @throws Exception
     */
    public function postTransaction(Request $request): JsonResponse // postar transação
    {
        $fields = $request->all();
        $result = $this->transactionService->doTransaction($fields);
        return response()->json($result);
    }
}