<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->resource['id'],
            'payer_wallet_id' => $this->resource['payer_wallet_id'],
            'payee_wallet_id' => $this->resource['payee_wallet_id'],
            'amount' => $this->resource['amount'],
            'created_at' => Carbon::parse($this->resource['created_at'])->format('d/m/Y H:i:s')
        ];
    }
}