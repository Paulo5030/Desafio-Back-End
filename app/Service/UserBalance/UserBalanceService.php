<?php

namespace App\Service\UserBalance;

use App\Exceptions\InsufficientFundsException;
use App\Service\Wallet\WalletService;

class UserBalanceService
{
    public function __construct(protected readonly WalletService $walletService)
    {
    }

    /**
     * @throws InsufficientFundsException
     */
    public function checkBalance($data): bool
    {
        $myWallet = $this->walletService->getWallet();
        $checkBalance = $this->walletService->checkUserBalance($myWallet, $data['amount']);

        if (!$checkBalance) { // verificar saldo do usuário
            throw new InsufficientFundsException();
        }
        return true;
    }
}
