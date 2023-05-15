<?php

namespace App\Exceptions;

use Fig\Http\Message\StatusCodeInterface;

class ErrorTransactionException extends AppException
{
    public function __construct()
    {
        parent::__construct(
            'An error occurred while executing a transaction',
            StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR
        );
    }
}
