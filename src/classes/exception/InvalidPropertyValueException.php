<?php

namespace touiteur\exception;

use Exception;

class InvalidPropertyValueException extends Exception{

    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}