<?php

namespace App\Infrastructure\Repositories;

use App\Application\DataObjects\PaginationObject;
use App\Domain\Entities\Character;
use App\Domain\Entities\CharacterCollection;
use App\Domain\Repositories\CharacterRepositoryInterface;
use App\Infrastructure\Exceptions\CharacterNotCreatedException;
use App\Infrastructure\Exceptions\CharactersNotFoundException;

class CharacterRepository implements CharacterRepositoryInterface
{
    public string $table = 'characters';
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

    public function all(PaginationObject $pagination): CharacterCollection
    {
        $charactersFetched = $this->baseRepository->all($pagination);

        if (!$charactersFetched) {
            throw new CharactersNotFoundException();
        }

        $characters = new CharacterCollection();
        foreach ($charactersFetched as $characterFetched) {
            $characters->add(Character::fromSqlResponse($characterFetched));
        }
        return $characters;
    }

    /**
     * @throws CharactersNotFoundException
     */
    public function find($id): Character
    {
        $characterFetched = $this->baseRepository->find($id);

        if (!$characterFetched) {
            throw new CharactersNotFoundException();
        }

        return Character::fromSqlResponse($characterFetched);
    }

    /**
     * @throws CharacterNotCreatedException
     * @throws CharactersNotFoundException
     */
    public function create($data): Character
    {
        $statement = $this->connection
            ->prepare(
                "INSERT INTO $this->table (name, birth_date, kingdom, equipment_id, faction_id) VALUES (:name, :birth_date, :kingdom, :equipment_id, :faction_id)
        ");
        $statement->execute($data);
        if ($statement->rowCount() === 0) {
            throw new CharacterNotCreatedException($data['name']);
        }
        $created = $this->connection->lastInsertId();
        return $this->find($created);

    }

    /**
     * @throws CharactersNotFoundException
     */
    public function update($id, $data): Character
    {
        $statement = $this->connection->prepare("UPDATE $this->table SET name = :name, birth_date = :birth_date, kingdom = :kingdom, equipment_id = :equipment_id, faction_id = :faction_id WHERE id = :id");
        $data['id'] = $id;
        $statement->execute($data);
        return $this->find($id);
    }

    /**
     * @throws CharactersNotFoundException
     */
    public function delete($id): bool
    {
        $this->find($id);
        return $this->baseRepository->delete($id);
    }

    public function convertFromCache(array $data): Character|CharacterCollection
    {
        if (isset($data['id'])) {
            return Character::fromArray($data);
        }
        return CharacterCollection::fromArray($data);
    }
}