<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Faction;
use App\Domain\Repositories\FactionRepositoryInterface;
use App\Infrastructure\Exceptions\FactionNotCreatedException;
use App\Infrastructure\Exceptions\FactionNotFoundException;
use App\Infrastructure\Exceptions\FactionsNotFoundException;
use \PDO;

class FactionRepository implements FactionRepositoryInterface
{
    private string $table = 'factions';

    function __construct(
        private PDO $connection
    )
    {
    }

    /**
     * @throws FactionsNotFoundException
     */
    public function all(): array
    {
        $statement = $this->connection->query("SELECT * FROM $this->table");
        $factionsFetched = $statement->fetchAll();

        if (!$factionsFetched) {
            throw new FactionsNotFoundException();
        }

        $factions = [];
        foreach ($factionsFetched as $factionFetched) {
            $factions[] = Faction::fromSqlResponse($factionFetched);
        }
        return $factions;
    }

    /**
     * @throws FactionNotFoundException
     */
    public function find($id): Faction
    {
        $statement = $this->connection->prepare("SELECT * FROM $this->table WHERE id = :id");
        $statement->execute(['id' => $id]);
        $factionFetched = $statement->fetch();

        if (!$factionFetched) {
            throw new FactionNotFoundException($id);
        }

        return Faction::fromSqlResponse($factionFetched);
    }

    /**
     * @throws FactionNotFoundException
     * @throws FactionNotCreatedException
     */
    public function create($data): Faction
    {
        $statement = $this->connection->prepare("INSERT INTO $this->table (faction_name, description) VALUES (:name, :description)");
        $statement->execute($data);

        if ($statement->rowCount() === 0) {
            throw new FactionNotCreatedException();
        }

        $factionId = $this->connection->lastInsertId();
        return $this->find($factionId);
    }

    /**
     * @throws FactionNotFoundException
     */
    public function update($id, $data): Faction
    {
        $statement = $this->connection->prepare("UPDATE $this->table SET faction_name = :name, description = :description WHERE id = :id");
        $statement->execute(array_merge($data, ['id' => $id]));

        return $this->find($id);
    }

    /**
     * @throws FactionNotFoundException
     */
    public function delete($id): bool
    {
        $this->find($id);
        $statement = $this->connection->prepare("DELETE FROM $this->table WHERE id = :id");
        $statement->execute(['id' => $id]);
        return $statement->rowCount() > 0;
    }
}