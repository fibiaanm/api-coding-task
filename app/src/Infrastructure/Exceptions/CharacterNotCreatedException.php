<?php

namespace App\Infrastructure\Exceptions;

class CharacterNotCreatedException extends \Exception
{

    public function __construct($name)
    {
        parent::__construct("Character {$name} not created");
    }

}