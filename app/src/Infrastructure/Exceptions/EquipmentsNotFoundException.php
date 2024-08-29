<?php

namespace App\Infrastructure\Exceptions;

class EquipmentsNotFoundException extends \Exception
{

        public function __construct()
        {
            parent::__construct('Equipments not found');
        }

}