<?php

namespace App\Exceptions;

use Fig\Http\Message\StatusCodeInterface;

class TransactionDeniedException extends AppException
{
    public function __construct()
    {
        parent::__construct(
            'Retailer is not authorized to make transactions',
            StatusCodeInterface::STATUS_UNAUTHORIZED
        );
    }
}
