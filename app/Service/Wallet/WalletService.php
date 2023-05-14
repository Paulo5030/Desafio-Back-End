<?php

namespace App\Service\Wallet;

use App\Repositories\Wallet\WalletRepository;

class WalletService
{
    public function __construct(protected WalletRepository $walletRepository)
    {
    }
    public function getWallet()
    {
        return $this->walletRepository->getWallet(); // pegar carteira
    }

    public function checkUserBalance($wallet, $amount): bool
    {
        return $this->walletRepository->checkUserBalance($wallet, $amount);
    }
}
