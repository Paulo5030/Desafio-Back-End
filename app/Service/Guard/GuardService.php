<?php

namespace App\Service\Guard;

use App\Exceptions\NotFoundException;
use App\Exceptions\TransactionDeniedException;
use Illuminate\Support\Facades\Auth;

class GuardService
{
    /**
     * @throws TransactionDeniedException
     * @throws NotFoundException
     */
    public function validateGuard(): void
    {
        if (!$this->guardCanTransfer()) { // guarda pode transferir
            throw new TransactionDeniedException();
        }
    }

    /**
     * @throws NotFoundException
     */
    public function guardCanTransfer(): bool // guarda pode transferir
    {
        if (Auth::guard('users')->check()) {
            return true;
        }
        if (Auth::guard('retailers')->check()) {
            return false;
        }
        throw new NotFoundException('Provider not found');
    }
}
