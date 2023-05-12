<?php

namespace App\Repositories\Wallet;

use App\Models\Transactions\Transaction;
use App\Models\Transactions\Wallet;
use Illuminate\Support\Facades\Auth;

class WalletRepository
{
    public function __construct(protected readonly Transaction $transaction)
    {
    }
    public function getWallet()
    {
        return Auth::user()->wallet;
    }

    public function checkUserBalance(Wallet $wallet, $money): bool // verificar saldo do usuário
    {
        return $wallet->balance >= $money;
    }
}
