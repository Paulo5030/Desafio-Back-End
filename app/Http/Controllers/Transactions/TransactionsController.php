<?php

namespace App\Http\Controllers\Transactions;

use App\Http\Controllers\Controller;
use App\Service\TransactionService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;


class TransactionsController extends Controller
{
    private TransactionService $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    /**
     * @throws ValidationException
     * @throws Exception
     */
    public function postTransaction(Request $request): JsonResponse // postar transação
    {
        $this->validate($request, [
            'provider' => 'required|in:users,retailers', // provedor
            'payee_id' => 'required', //
            'amount' => 'required|numeric'
        ]);

        $fields = $request->only(['provider', 'payee_id', 'amount']);
            $result = $this->transactionService->doTransaction($fields);
            return response()->json($result);
        }
}