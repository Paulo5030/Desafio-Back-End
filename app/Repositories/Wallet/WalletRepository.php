<?php

namespace App\Repositories\Wallet;

use App\Models\Transactions\Wallet;
use Illuminate\Support\Facades\Auth;

class WalletRepository
{
    public function getWallet()
    {
        return Auth::user()->wallet;
    }

    public function checkUserBalance(Wallet $wallet, $amount): bool // verificar saldo do usuário
    {
        return $wallet->balance >= $amount;
    }

    public function checkUser(Wallet $wallet, $user): bool
    {
        return $wallet->user_id === $user;
    }
}
