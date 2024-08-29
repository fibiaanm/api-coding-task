<?php

namespace App\Domain\Entities;

class CharacterCollection
{
    private array $characters = [];

    public function add(Character $character): void
    {
        $this->characters[] = $character;
    }

    public function count(): int
    {
        return count($this->characters);
    }

    public function toArray(): array
    {
        $characters = [];
        foreach ($this->characters as $character) {
            $characters[] = $character->toArray();
        }
        return $characters;
    }

    static function fromArray($characters): CharacterCollection
    {
        $characterCollection = new CharacterCollection();
        foreach ($characters as $character) {
            $characterCollection->add(Character::fromArray($character));
        }
        return $characterCollection;
    }

}