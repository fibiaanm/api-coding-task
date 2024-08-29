<?php

namespace App\Infrastructure\Exceptions;

class UserTokenInvalidException extends \Exception
{

        public function __construct()
        {
            parent::__construct("User token invalid");
        }

}