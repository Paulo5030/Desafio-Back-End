<?php

namespace App\Repositories\Transaction;

use App\Models\Transactions\Transaction;
use Illuminate\Support\Facades\Auth;

class TransactionRepository
{
   public function __construct(Transaction $transaction)
   {
       $this->model = $transaction;
   }
   public function doTransaction ()
   {
       return Auth::user()->wallet;
   }
}