<?php

namespace App\Exceptions;

class TransactionDeniedException extends AppException
{
    public function __construct()
    {
        parent::__construct('Retailer is not authorized to make transactions', 401);
    }
}