<?php

namespace touiteur\exception;

use Exception;

class InvalidPropertyValueException extends Exception
{

    /**
     * @param string $message
     */
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}