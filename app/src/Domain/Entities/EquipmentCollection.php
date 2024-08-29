<?php

namespace App\Domain\Entities;

class EquipmentCollection
{
    private array $equipments = [];

    public function add(Equipment $equipment): void
    {
        $this->equipments[] = $equipment;
    }

    public function count(): int
    {
        return count($this->equipments);
    }

    public function toArray(): array
    {
        $equipments = [];
        foreach ($this->equipments as $equipment) {
            $equipments[] = $equipment->toArray();
        }
        return $equipments;
    }

    static function fromArray($equipments): EquipmentCollection
    {
        $equipmentCollection = new EquipmentCollection();
        foreach ($equipments as $equipment) {
            $equipmentCollection->add(Equipment::fromArray($equipment));
        }
        return $equipmentCollection;
    }

}