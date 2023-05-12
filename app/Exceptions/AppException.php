<?php

namespace App\Exceptions;

use Fig\Http\Message\StatusCodeInterface;
use Throwable;

class AppException extends \Exception
{
    /**
     * @var mixed|string
     */
    protected $message;

    /**
     * @var int|mixed
     */
    protected $code;

    /**
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(
        string $message = '',
        int $code = StatusCodeInterface::STATUS_BAD_REQUEST,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
        $this->message = $message;
        $this->code = $code;
    }
}
