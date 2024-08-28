<?php

namespace App\Infrastructure\Exceptions;

class FactionNotCreatedException extends \Exception
{
    public function __construct()
    {
        parent::__construct("Faction not created");
    }

}