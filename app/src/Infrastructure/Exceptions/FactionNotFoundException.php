<?php

namespace App\Infrastructure\Exceptions;

class FactionNotFoundException extends \Exception
{

    public function __construct($id)
    {
        parent::__construct("Faction with id $id not found");
    }
}