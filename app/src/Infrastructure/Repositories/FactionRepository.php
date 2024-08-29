<?php

namespace App\Infrastructure\Repositories;

use App\Application\DataObjects\PaginationObject;
use App\Domain\Entities\Faction;
use App\Domain\Entities\FactionCollection;
use App\Domain\Repositories\BaseRepositoryInterface;
use App\Domain\Repositories\FactionRepositoryInterface;
use App\Infrastructure\Exceptions\FactionNotCreatedException;
use App\Infrastructure\Exceptions\FactionNotFoundException;
use App\Infrastructure\Exceptions\FactionsNotFoundException;
use \PDO;

class FactionRepository implements FactionRepositoryInterface
{
    public string $table = 'factions';
    private BaseRepositoryInterface $baseRepository;

    function __construct(
        private readonly PDO $connection
    ) {
        $this->baseRepository = new BaseRepository(
            $connection,
            $this->table
        );
    }

    /*
     * @throws FactionsNotFoundException
     */
    public function all(PaginationObject $pagination): FactionCollection
    {
        $factionsFetched = $this->baseRepository->all($pagination);

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
        $factionFetched = $this->baseRepository->find($id);

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

        $created = $this->connection->lastInsertId();

        return $this->find($created);
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
        return $this->baseRepository->delete($id);
    }

    public function convertFromCache(array $data): Faction|FactionCollection
    {
        if (isset($data['name'])) {
            return Faction::fromArray($data);
        }

        return FactionCollection::fromArray($data);
    }
}