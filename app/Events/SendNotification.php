<?php

namespace App\Events;

use App\Models\Transactions\Transaction;

class SendNotification extends Event
{
    public Transaction $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }
}
