<?php

namespace App\Domain\Repositories;

use App\Application\DataObjects\PaginationObject;
use App\Domain\Entities\Equipment;
use App\Domain\Entities\EquipmentCollection;
use App\Infrastructure\Exceptions\EquipmentNotFoundException;
use App\Infrastructure\Exceptions\EquipmentsNotFoundException;

interface EquipmentRepositoryInterface
{

    /**
     * @param PaginationObject $pagination
     * @return EquipmentCollection
     * @throws EquipmentsNotFoundException
     */
    public function all(PaginationObject $pagination): EquipmentCollection;

    /**
     * @param $id
     * @return Equipment
     * @throws EquipmentNotFoundException
     */
    public function find($id): Equipment;

    /**
     * @param $data
     * @return Equipment
     * @throws EquipmentNotFoundException
     */
    public function create($data): Equipment;

    /**
     * @param $id
     * @param $data
     * @return Equipment
     * @throws EquipmentNotFoundException
     */
    public function update($id, $data): Equipment;

    /**
     * @param $id
     * @return bool
     * @throws EquipmentNotFoundException
     */
    public function delete($id): bool;
}