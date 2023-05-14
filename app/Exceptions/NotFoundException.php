<?php

namespace App\Exceptions;

use Fig\Http\Message\StatusCodeInterface;

class NotFoundException extends AppException
{
    public function __construct(string $message)
    {
        parent::__construct($message, StatusCodeInterface::STATUS_NOT_FOUND);
    }
}
