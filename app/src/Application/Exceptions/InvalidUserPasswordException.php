<?php

namespace App\Application\Exceptions;

class InvalidUserPasswordException extends \Exception
{

    public function __construct(string $name)
    {
        parent::__construct("Password invalid for user $name");
    }

}