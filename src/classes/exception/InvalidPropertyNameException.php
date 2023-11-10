<?php

namespace touiteur\exception;

use Exception;

class InvalidPropertyNameException extends Exception
{

    /**
     * @param string $message
     */
    public function __construct(string $message)
    {
        parent::__construct($message);
    }

}