<?php

namespace Exception;

use Exception as E;
use Throwable;

class AuthException extends E
{
    private string $field = '';

    /**
     * @param string $message
     * @param string $field
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = '', string $field = '', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->field = $field;
    }

    /**
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
    }
}