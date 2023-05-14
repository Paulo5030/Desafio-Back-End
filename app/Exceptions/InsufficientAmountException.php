<?php

namespace App\Exceptions;


class InsufficientAmountException extends AppException
{
    public function __construct()
    {
        parent::__construct('Insufficient amount');
    }
}
