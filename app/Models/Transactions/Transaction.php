<?php

namespace App\Models\Transactions;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public $incrementing = false;

    protected $table = 'wallet_transactions'; //transações de carteira

    protected $fillable = [
       'id',
       'payer_wallet_id', // pagador
       'payee_wallet_id', // beneficiario
       'amount' // quantia
    ];

    public function walletPayer()
    {
        return $this->belongsTo(Wallet::class, 'payer_wallet_id');
    }
    public function walletPayee()
    {
        return $this->belongsTo(Wallet::class, 'payee_wallet_id');
    }
}
