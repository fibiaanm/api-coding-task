<?php

namespace App\Infrastructure\Exceptions;

class UserNotFoundException extends \Exception
{
    public function __construct($name)
    {
        parent::__construct("User with name $name not found");
    }
}