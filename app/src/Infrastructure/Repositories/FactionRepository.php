<?php

namespace App\Infrastructure\Repositories;

use App\Application\DataObjects\PaginationObject;
use App\Domain\Entities\Faction;
use App\Domain\Entities\FactionCollection;
use App\Domain\Repositories\FactionRepositoryInterface;
use App\Infrastructure\Exceptions\FactionNotCreatedException;
use App\Infrastructure\Exceptions\FactionNotFoundException;
use App\Infrastructure\Exceptions\FactionsNotFoundException;
use \PDO;

class FactionRepository implements FactionRepositoryInterface
{
    public string $table = 'factions';

    function __construct(
        private PDO $connection
    )
    {
    }

    /*
     * @throws FactionsNotFoundException
     */
    public function all(PaginationObject $pagination): FactionCollection
    {
        $offset = $pagination->getOffset();
        $statement = $this->connection->query("SELECT * FROM $this->table LIMIT $pagination->limit OFFSET $offset");
        $factionsFetched = $statement->fetchAll();

        if (!$factionsFetched) {
            throw new FactionsNotFoundException();
        }

        $factions = new FactionCollection();
        foreach ($factionsFetched as $factionFetched) {
            $factions->add(Faction::fromSqlResponse($factionFetched));
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

    public function convertFromCache(array $data): Faction|FactionCollection
    {
        if (isset($data['name'])) {
            return Faction::fromArray($data);
        }

        return FactionCollection::fromArray($data);
    }
}