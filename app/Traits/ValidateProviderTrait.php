<?php

namespace App\Traits;

use App\Exceptions\NotFoundException;
use App\Models\Retailer;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;

trait ValidateProviderTrait
{
    /**
     * @throws NotFoundException
     */
    private function getProvider(string $provider): Authenticatable // obter provedor
    {
        if ($provider == "user") {
            return new User();
        }
        if ($provider == "retailer") {
            return new Retailer();
        }
        throw new NotFoundException('Provider not found');
    }
}
