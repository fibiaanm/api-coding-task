<?php

namespace App\Infrastructure\Repositories;

use App\Application\DataObjects\PaginationObject;
use App\Domain\Repositories\BaseRepositoryInterface;

class BaseRepository implements BaseRepositoryInterface
{

    function __construct(
        private readonly \PDO $connection,
        private readonly string $table
    )
    {

    }

    public function all(PaginationObject $pagination): array
    {
        $offset = $pagination->getOffset();
        $statement = $this->connection->query("SELECT * FROM $this->table LIMIT $pagination->limit OFFSET $offset");
        return $statement->fetchAll();
    }

    public function find($id): mixed
    {
        $statement = $this->connection->prepare("SELECT * FROM $this->table WHERE id = :id");
        $statement->execute(['id' => $id]);
        return $statement->fetch();
    }

    public function delete($id): int
    {
        $statement = $this->connection->prepare("DELETE FROM $this->table WHERE id = :id");
        $statement->execute(['id' => $id]);
        return $statement->rowCount();
    }
}