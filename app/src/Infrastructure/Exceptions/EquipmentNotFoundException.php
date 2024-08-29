<?php

namespace App\Infrastructure\Exceptions;

class EquipmentNotFoundException extends \Exception
{

        public function __construct()
        {
            parent::__construct('Equipment not found');
        }

}