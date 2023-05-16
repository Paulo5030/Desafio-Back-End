<?php

namespace App\Service\UserBalance;

use App\Exceptions\InsufficientAmountException;
use App\Exceptions\UnauthorizedException;
use App\Service\Wallet\WalletService;

class UserBalanceService
{
    public function __construct(protected WalletService $walletService)
    {
    }

    /**
     * @throws InsufficientAmountException
     */
    public function checkBalance($data): bool
    {
        $myWallet = $this->walletService->getWallet();
        $checkBalance = $this->walletService->checkUserBalance($myWallet, $data['amount']);

        if (!$checkBalance) { // verificar saldo do usuário
            throw new InsufficientAmountException();
        }
        return true;
    }

    /**
     * @throws UnauthorizedException
     */
    public function checkUser($data): bool
    {
        $myWallet = $this->walletService->getWallet();
        $checkUser = $this->walletService->checkUser($myWallet, $data['payee_id']);

        if ($checkUser) {
            throw new UnauthorizedException();
        }
        return false;
    }
}
