<?php

namespace App\Service;

use App\Events\SendNotification;
use App\Exceptions\IdleServiceException;
use App\Exceptions\InsufficientFundsException;
use App\Exceptions\TransactionDeniedException;
use App\Models\Retailer;
use App\Models\Transactions\Transaction;
use App\Models\Transactions\Wallet;
use App\Models\User;
use App\Repositories\Transaction\TransactionRepository;
use Exception;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\InvalidDataProviderException;
use Ramsey\Uuid\Uuid;

class TransactionService
{
    public function __construct(protected TransactionRepository $transactionRepository)
    {

    }

    /**
     * @throws Exception
     * @throws TransactionDeniedException
     */
    public function handle(array $data): Transaction
    {
        if (!$this->guardCanTransfer()) {
            throw new TransactionDeniedException('Retailer is not authorized to make transactions', 401);
        }

        if(!$payee = $this->retrievePayee($data)) {
            throw new InvalidDataProviderException('User Not Found', 404);
        }

        $myWallet = Auth::guard($this->transactionRepository->doTransaction($data['provider']))->user()->wallet;

        if (!$this->checkUserBalance($myWallet, $data['amount'])) {
            throw new InsufficientFundsException('Yu dont have money', 422);
        }

        if ($this->isServiceAbleToMakeTransaction()) {
            throw new IdleServiceException('Service is not responding. Try again later.');
        }

        return $this->makeTransaction($payee, $data); // fazer transação
    }

    public function guardCanTransfer(): bool // guarda pode transferir
    {
        if (Auth::guard('users')->check()) {
            return true;
        }
        if (Auth::guard('retailers')->check()) {
            return false;
        }
        throw new InvalidDataProviderException('Provider not found', 422);
    }

    /**
     * @throws Exception
     */
    public function getProvider(string $provider): Authenticatable // obter provedor
    {
        if ($provider == "users") {
            return new User();
        }
        if ($provider == "retailers") {
            return new Retailer();
        }
        throw new InvalidDataProviderException('Provider not found');

    }

    private function checkUserBalance(Wallet $wallet, float $money): bool // verificar saldo do usuário
    {
        return $wallet->balance >= $money;
    }
    /*
     * Function know if the user exists on provider
     * both functions should trigger an exception
     * when something is wrong
     */
    /**
     * @throws Exception
     */
    private function retrievePayee(array $data) // recuperar Beneficiário
    {
        try {
            $model = $this->getProvider($data['provider']);
            return $model->find($data['payee_id']);
        } catch (InvalidDataProviderException | \Exception $e) {
            return false;
        }

    }


    private function makeTransaction($payee, array $data) // fazer transação
    {
        $payload = [
            'id' => Uuid::uuid4()->toString(),
            'payer_wallet_id' => Auth::guard($data['provider'])->user()->wallet->id,
            'payee_wallet_id' => $payee->wallet->id,
            'amount' => $data['amount']
        ];

        return DB::transaction(function () use ($payload) {
            $transaction = Transaction::create($payload);

            $transaction->walletPayer->withdraw($payload['amount']);
            $transaction->walletPayee->deposit($payload['amount']);

            event(new SendNotification($transaction));

            return $transaction;
        });
    }
    private function isServiceAbleToMakeTransaction(): bool // o serviço é capaz de fazer transações
    {
        $service = app(MockService::class)->authorizeTransaction();
        return $service ['message'] == 'Autorizado';
    }
}