<?php

namespace App\Service\Wallet;

use App\Repositories\Wallet\WalletRepository;

class WalletService
{
    public function __construct(protected readonly WalletRepository $walletRepository)
    {
    }
    public function getWallet()
    {
        return $this->walletRepository->getWallet(); // pegar carteira
    }

    public function checkUserBalance($wallet, $money): bool
    {
        return $this->walletRepository->checkUserBalance($wallet, $money);
    }
}
