<?php

namespace App\Service\AuthorizeTransaction;

use Illuminate\Support\Facades\Http;

class AuthorizeTransactionService
{
    private const AUTHORIZATION = 'https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6';
    public function authorizeTransaction(): bool //  autorizar transação
    {
        $response = Http::get(self::AUTHORIZATION);
        if ($response->json()['message'] === 'Autorizado') {
            return true;
        }

        return false;
    }
}
