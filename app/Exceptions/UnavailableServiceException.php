<?php

namespace App\Exceptions;

class UnavailableServiceException extends AppException
{
    public function __construct()
    {
        parent::__construct('Service is not responding. Try again later.');
    }
}