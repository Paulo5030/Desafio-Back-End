<?php

namespace App\Models\Transactions;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    public $incrementing = false;
    protected $fillable = [
        'id', 'user_id', 'balance'
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function deposit($value) // depositar
    {
        $this->update([
           'balance' => $this->attributes['balance'] + $value
        ]);
    }

    public function withdraw($value) // retirar
    {
        $this->update([
           'balance' => $this->attributes['balance'] - $value
        ]);
    }
}
