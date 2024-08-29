<?php

namespace App\Infrastructure\Exceptions;

class EquipmentNotCreatedException extends \Exception
{

    public function __construct()
    {
        parent::__construct('Equipment not created');
    }
}