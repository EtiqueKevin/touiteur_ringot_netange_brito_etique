<?php

namespace touiteur\exception;

use Exception;

class InvalidPropertyNameException extends Exception{

        public function __construct(string $message)
        {
            parent::__construct($message);
        }

}