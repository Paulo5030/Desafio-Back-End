<?php

namespace App\Exceptions;

class NotFoundException extends AppException
{
    public function __construct(string $message)
    {
        parent::__construct($message, 422);
    }
}