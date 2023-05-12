<?php

namespace App\Exceptions;

use Fig\Http\Message\StatusCodeInterface;

class InsufficientFundsException extends AppException
{
    public function __construct()
    {
        parent::__construct('You dont have money', StatusCodeInterface::STATUS_FORBIDDEN);
    }
}
