<?php

namespace App\Infrastructure\Exceptions;

class UserTokenExpired extends \Exception
{
    public function __construct()
    {
        parent::__construct("User token expired");
    }
}