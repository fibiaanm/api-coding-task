<?php

namespace App\Domain\Entities;

class Character
{
    public int $id;
    public string $name;
    public string $birth_date;
    public string $kingdom;
    public int $equipmentId;
    public int $factionId;

    static function fromSqlResponse(
        array $data
    ): Character {
        $character = new Character();
        $character->id = $data['id'];
        $character->name = $data['name'];
        $character->birth_date = $data['birth_date'];
        $character->kingdom = $data['kingdom'];
        $character->equipmentId = $data['equipment_id'];
        $character->factionId = $data['faction_id'];
        return $character;
    }

    static function fromArray(
        array $data
    ): Character {
        $character = new Character();
        $character->id = $data['id'];
        $character->name = $data['name'];
        $character->birth_date = $data['birth_date'];
        $character->kingdom = $data['kingdom'];
        $character->equipmentId = $data['equipmentId'];
        $character->factionId = $data['factionId'];
        return $character;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'birth_date' => $this->birth_date,
            'kingdom' => $this->kingdom,
            'equipmentId' => $this->equipmentId,
            'factionId' => $this->factionId,
        ];
    }

}