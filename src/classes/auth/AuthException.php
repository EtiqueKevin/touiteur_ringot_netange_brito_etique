<?php

namespace iutnc\deefy\auth;


use Exception;

class AuthException extends Exception{

    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}