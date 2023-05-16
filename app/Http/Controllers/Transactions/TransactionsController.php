<?php

namespace App\Http\Controllers\Transactions;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Service\Guard\GuardService;
use App\Service\Payee\PayeeService;
use App\Service\Transaction\TransactionService;
use Exception;
use Illuminate\Http\JsonResponse;

class TransactionsController extends Controller
{
    public function __construct(
        protected TransactionService $transactionService,
        protected GuardService $guardService,
        protected PayeeService $payeeService
    ) {
    }

    /**
     * @throws Exception
     */
    public function transaction(TransactionRequest $request): JsonResponse // postar transação
    {
        $data = $request->all();
        $this->guardService->validateGuard();
        $payee = $this->payeeService->checkBeneficiary($data);
        $result = $this->transactionService->transaction($data, $payee);
        return response()->json(new TransactionResource($result));
    }
}
