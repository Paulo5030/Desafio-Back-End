<?php

namespace App\Http\Controllers\Transactions;

use App\Http\Controllers\Controller;
use App\Service\Transaction\TransactionService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    public function __construct(protected readonly TransactionService $transactionService)
    {
    }

    /**
     * @throws Exception
     */
    public function postTransaction(Request $request): JsonResponse // postar transação
    {
        $fields = $request->all();
        $result = $this->transactionService->execute($fields);
        return response()->json($result);
    }
}
