<?php

namespace App\Exceptions;

use Fig\Http\Message\StatusCodeInterface;

class ProviderUnauthorizedException extends AppException
{
    public function __construct()
    {
        parent::__construct(
            ' Provider Unauthorized',
            StatusCodeInterface::STATUS_UNAUTHORIZED
        );
    }
}
