<?php

namespace App\Application\Services;

use App\Application\DataObjects\PaginationObject;
use App\Domain\Entities\Equipment;
use App\Domain\Entities\EquipmentCollection;
use App\Domain\Repositories\EquipmentRepositoryInterface;
use App\Infrastructure\Exceptions\EquipmentNotFoundException;
use App\Infrastructure\Exceptions\EquipmentsNotFoundException;

class EquipmentService
{

    public function __construct(
        /**
         * @var EquipmentRepositoryInterface
         */
        private readonly CacheDecoratorService $equipmentRepository
    )
    {
    }

    /**
     * @throws EquipmentsNotFoundException
     */
    public function list(PaginationObject $pagination): EquipmentCollection
    {
        $equipmentCollection = $this->equipmentRepository->all($pagination);
        $pagination->setTotal($equipmentCollection->count());
        return $equipmentCollection;
    }

    /**
     * @throws EquipmentNotFoundException
     */
    public function detail($id): Equipment
    {
        return $this->equipmentRepository->find($id);
    }

    /**
     * @throws EquipmentNotFoundException
     */
    public function create($data): Equipment
    {
        return $this->equipmentRepository->create($data);
    }

    /**
     * @throws EquipmentNotFoundException
     */
    public function update($id, $data): Equipment
    {
        return $this->equipmentRepository->update($id, $data);
    }

    /**
     * @throws EquipmentNotFoundException
     */
    public function delete($id): bool
    {
        return $this->equipmentRepository->delete($id);
    }

}