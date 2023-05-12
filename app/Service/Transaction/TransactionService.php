<?php

namespace App\Service\Transaction;

use App\Events\SendNotification;
use App\Exceptions\ErrorTransaction;
use App\Exceptions\UnavailableServiceException;
use App\Models\Transactions\Transaction;
use App\Service\AuthorizeTransaction\AuthorizeTransactionService;
use App\Service\Guard\GuardService;
use App\Service\Payee\PayeeService;
use App\Service\UserBalance\UserBalanceService;
use App\Service\Wallet\WalletService;
use App\Traits\ValidateProviderTrait;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class TransactionService
{
    use ValidateProviderTrait;

    public function __construct(
        private readonly GuardService $guardService,
        private readonly WalletService $walletService,
        private readonly PayeeService $payeeService,
        private readonly UserBalanceService $balance,
        private readonly AuthorizeTransactionService $authorizeTransactionService
    ) {
    }

    /**
     * @throws Exception
     */
    public function execute(array $data)// fazer transação
    {
        $this->guardService->validateGuard();
        $payee = $this->payeeService->checkBeneficiary($data);
        $this->balance->checkBalance($data);

        return $this->transaction($payee, $data);
    }

    /**
     * @throws UnavailableServiceException
     * @throws ErrorTransaction
     */
    public function transaction($payee, array $data) // fazer transação
    {
        if ($this->authorizeTransactionService->authorizeTransaction()) {
            $payload = [
                'id' => Uuid::uuid4()->toString(),
                'payer_wallet_id' => Auth::user()->wallet->id,
                'payee_wallet_id' => $payee->wallet->id,
                'amount' => $data['amount']
            ];

            try {
                return DB::transaction(function () use ($payload) {
                    $transaction = Transaction::create($payload);

                    $transaction->walletPayer->withdraw($payload['amount']);
                    $transaction->walletPayee->deposit($payload['amount']);

                    event(new SendNotification($transaction));
                    DB::commit();
                    return response()->json($transaction);
                });
            } catch (\Exception $e) {
                throw new ErrorTransaction();
            }
        }
    }
}
