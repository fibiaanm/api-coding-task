<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Faction;
use App\Domain\Repositories\FactionRepositoryInterface;
use \PDO;

class FactionRepository implements FactionRepositoryInterface
{
    function __construct(
        private PDO $connection
    )
    {
    }

    public function all(): array
    {
        $statement = $this->connection->query('SELECT * FROM factions');
        $factionsFetched = $statement->fetchAll();
        $factions = [];
        foreach ($factionsFetched as $factionFetched) {
            $factions[] = Faction::fromSqlResponse($factionFetched);
        }
        return $factions;
    }

    public function find($id): Faction
    {
        $statement = $this->connection->prepare('SELECT * FROM factions WHERE id = :id');
        $statement->execute(['id' => $id]);
        $factionFetched = $statement->fetch();
        return Faction::fromSqlResponse($factionFetched);
    }

    public function create($data): Faction
    {
        $statement = $this->connection->prepare('INSERT INTO factions (faction_name, description) VALUES (:faction_name, :description)');
        $statement->execute($data);

        $factionId = $this->connection->lastInsertId();
        return $this->find($factionId);
    }

    public function update($id, $data)
    {
        // TODO: Implement update() method.
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }
}