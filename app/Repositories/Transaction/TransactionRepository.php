<?php

namespace App\Repositories\Transaction;

use App\Models\Transactions\Transaction;

class TransactionRepository
{
    public function create($payload)
    {
        return Transaction::create($payload);
    }
}