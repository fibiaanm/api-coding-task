<?php

namespace App\Infrastructure\Exceptions;

class UserTokenNotProvidedException extends \Exception
{

    public function __construct()
    {
        parent::__construct("User token not provided");
    }

}