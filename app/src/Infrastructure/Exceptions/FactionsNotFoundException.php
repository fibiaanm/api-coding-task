<?php

namespace App\Infrastructure\Exceptions;

class FactionsNotFoundException extends \Exception
{
    public function __construct()
    {
        parent::__construct("Factions not found");
    }
}