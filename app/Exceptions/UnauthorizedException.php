<?php

namespace App\Exceptions;

use Fig\Http\Message\StatusCodeInterface;

class UnauthorizedException extends AppException
{
    public function __construct()
    {
        parent::__construct(
            'Unauthorized transaction',
            StatusCodeInterface::STATUS_UNAUTHORIZED
        );
    }
}
