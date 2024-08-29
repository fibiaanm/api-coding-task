<?php

namespace App\Domain\Entities;

class Faction
{
    public int $id;
    public string $name;
    public string $description;


    static function fromSqlResponse(
        array $data
    ): Faction {
        $faction = new Faction();
        $faction->id = $data['id'];
        $faction->name = $data['faction_name'];
        $faction->description = $data['description'];
        return $faction;
    }

    static function fromArray(
        array $data
    ): Faction {
        $faction = new Faction();
        $faction->id = $data['id'];
        $faction->name = $data['name'];
        $faction->description = $data['description'];
        return $faction;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
        ];
    }
}