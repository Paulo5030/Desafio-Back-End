<?php

namespace App\Service\Guard;

use App\Exceptions\ProviderUnauthorizedException;
use Illuminate\Support\Facades\Auth;

class GuardService
{
    /**
     * @throws ProviderUnauthorizedException
     */
    public function validateGuard(): void
    {
        if (!$this->guardCanTransfer()) { // guarda pode transferir
            throw new ProviderUnauthorizedException();
        }
    }

    public function guardCanTransfer(): bool // guarda pode transferir
    {
        if (Auth::guard('users')->check()) {
            return true;
        }
        return false;
    }
}
