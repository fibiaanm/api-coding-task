<?php

namespace App\Infrastructure\Exceptions;

class CharacterNotFoundException extends \Exception
{

        public function __construct($id)
        {
            parent::__construct("Character {$id} not found");
        }

}