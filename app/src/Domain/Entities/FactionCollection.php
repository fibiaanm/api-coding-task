<?php

namespace App\Domain\Entities;

class FactionCollection
{
    private array $factions = [];

    public function add(Faction $faction): void
    {
        $this->factions[] = $faction;
    }

    public function toArray(): array
    {
        $factions = [];
        foreach ($this->factions as $faction) {
            $factions[] = $faction->toArray();
        }
        return $factions;
    }

    static function fromArray($factions): FactionCollection
    {
        $factionCollection = new FactionCollection();
        foreach ($factions as $faction) {
            $factionCollection->add(Faction::fromArray($faction));
        }
        return $factionCollection;
    }

}