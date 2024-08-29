<?php

namespace App\Infrastructure\Repositories;

use App\Application\DataObjects\PaginationObject;
use App\Domain\Entities\Equipment;
use App\Domain\Entities\EquipmentCollection;
use App\Domain\Repositories\EquipmentRepositoryInterface;
use App\Infrastructure\Exceptions\EquipmentNotFoundException;
use App\Infrastructure\Exceptions\EquipmentsNotFoundException;

class EquipmentRepository implements EquipmentRepositoryInterface
{
    public string $table = 'equipments';
    private BaseRepository $baseRepository;
    public function __construct(
        private \PDO $connection
    )
    {
        $this->baseRepository = new BaseRepository(
            $connection,
            $this->table
        );
    }

    public function all(PaginationObject $pagination): EquipmentCollection
    {
        $equipmentsFetched = $this->baseRepository->all($pagination);

        if (!$equipmentsFetched) {
            throw new EquipmentsNotFoundException();
        }

        $equipments = new EquipmentCollection();
        foreach ($equipmentsFetched as $equipmentFetched) {
            $equipments->add(Equipment::fromSqlResponse($equipmentFetched));
        }
        return $equipments;

    }

    public function find($id): Equipment
    {
        $equipmentFetched = $this->baseRepository->find($id);

        if (!$equipmentFetched) {
            throw new EquipmentNotFoundException();
        }

        return Equipment::fromSqlResponse($equipmentFetched);
    }

    public function create($data): Equipment
    {
        $statement = $this->connection->prepare(
            "INSERT INTO {$this->table} (name, type, made_by) VALUES (:name, :type, :made_by)"
        );
        $statement->execute($data);
        if ($statement->rowCount() === 0) {
            throw new EquipmentNotFoundException();
        }
        $created = $this->connection->lastInsertId();
        return $this->find($created);
    }

    public function update($id, $data): Equipment
    {
        $statement = $this->connection->prepare(
            "UPDATE {$this->table} SET name = :name, type = :type, made_by = :made_by WHERE id = :id"
        );
        $statement->execute(array_merge($data, ['id' => $id]));
        if ($statement->rowCount() === 0) {
            throw new EquipmentNotFoundException();
        }
        return $this->find($id);
    }

    public function delete($id): bool
    {
        $this->find($id);
        return $this->baseRepository->delete($id);
    }

    public function convertFromCache(array $data): Equipment|EquipmentCollection
    {
        if (isset($data['id'])) {
            return Equipment::fromArray($data);
        }
        $equipments = new EquipmentCollection();
        foreach ($data as $equipment) {
            $equipments->add(Equipment::fromArray($equipment));
        }
        return $equipments;
    }
}