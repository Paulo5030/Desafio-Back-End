<?php

namespace App\Exceptions;

class InsufficientFundsException extends AppException
{
    public function __construct()
    {
        parent::__construct('Yu dont have money', 403);
    }
}