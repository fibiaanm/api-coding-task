<?php

namespace App\Domain\Entities;

class Equipment
{
    public int $id;
    public string $name;
    public string $type;
    public string $madeBy;

    static function fromSqlResponse(
        array $data
    ): Equipment {
        $equipment = new Equipment();
        $equipment->id = $data['id'];
        $equipment->name = $data['name'];
        $equipment->type = $data['type'];
        $equipment->madeBy = $data['made_by'];
        return $equipment;
    }

    static function fromArray(
        array $data
    ): Equipment {
        $equipment = new Equipment();
        $equipment->id = $data['id'];
        $equipment->name = $data['name'];
        $equipment->type = $data['type'];
        $equipment->madeBy = $data['madeBy'];
        return $equipment;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'madeBy' => $this->madeBy,
        ];
    }

}