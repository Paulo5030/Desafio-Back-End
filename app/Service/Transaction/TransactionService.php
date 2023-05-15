<?php

namespace App\Service\Transaction;

use App\Events\SendNotification;
use App\Exceptions\ErrorTransaction;
use App\Exceptions\InsufficientAmountException;
use App\Exceptions\NotFoundException;
use App\Exceptions\UnauthorizedException;
use App\Exceptions\UnavailableServiceException;
use App\Repositories\Transaction\TransactionRepository;
use App\Service\AuthorizeTransaction\AuthorizeTransactionService;
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
        protected WalletService $walletService,
        protected UserBalanceService $balance,
        protected AuthorizeTransactionService $authorizeTransactionService,
        protected TransactionRepository $transactionRepository
    ) {
    }
    /**
     * @throws Exception
     */
    public function getDataTransaction(array $data, $payee): array// fazer transação
    {
        return [
            'id' => Uuid::uuid4()->toString(),
            'payer_wallet_id' => Auth::user()->wallet->id,
            'payee_wallet_id' => $payee->wallet->id,
            'amount' => $data['amount']
        ];
    }
    /**
     * @throws UnavailableServiceException
     * @throws ErrorTransaction
     * @throws UnauthorizedException
     * @throws InsufficientAmountException
     * @throws NotFoundException
     * @throws Exception
     */
    public function transaction(array $data, $payee) // fazer transação
    {
        if ($this->authorizeTransactionService->authorizeTransaction()) {
            $this->balance->checkBalance($data);
            $payload = $this->getDataTransaction($data, $payee);

            DB::beginTransaction();
            try {
                $transaction = $this->transactionRepository->create($payload);
                $transaction->walletPayer->withdraw($payload['amount']);
                $transaction->walletPayee->deposit($payload['amount']);

                event(new SendNotification($transaction));
                DB::commit();
                return $transaction;
            } catch (\Exception $e) {
                DB::rollBack();
                throw new ErrorTransaction();
            }
        }

        throw new UnauthorizedException();
    }
}
