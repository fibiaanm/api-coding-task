<?php

namespace App\Infrastructure\Exceptions;

class CharactersNotFoundException extends \Exception
{

    public function __construct()
    {
        parent::__construct("Characters not found");
    }

}