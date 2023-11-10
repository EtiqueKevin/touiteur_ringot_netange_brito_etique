<?php

namespace touiteur\auth;


use Exception;

class AuthException extends Exception
{

    /**
     * @param string $message
     */
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}