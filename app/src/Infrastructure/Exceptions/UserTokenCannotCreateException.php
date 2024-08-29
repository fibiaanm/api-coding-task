<?php

namespace App\Infrastructure\Exceptions;

class UserTokenCannotCreateException extends \Exception
{
    public function __construct()
    {
        parent::__construct("User token cannot be created");
    }
}