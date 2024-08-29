<?php

namespace App\Application\Services;

use App\Application\DataObjects\PaginationObject;
use App\Domain\Entities\Character;
use App\Domain\Entities\CharacterCollection;
use App\Domain\Repositories\CharacterRepositoryInterface;
use App\Application\Services\CacheDecoratorService;
use App\Infrastructure\Exceptions\CharacterNotCreatedException;
use App\Infrastructure\Exceptions\CharacterNotFoundException;
use App\Infrastructure\Exceptions\CharactersNotFoundException;

class CharacterService
{

    public function __construct(
        /**
         * @var CharacterRepositoryInterface
         */
        private readonly CacheDecoratorService $characterRepository
    )
    {
    }

    /**
     * @throws CharactersNotFoundException
     */
    public function list(PaginationObject $pagination): CharacterCollection
    {
        $characterCollection = $this->characterRepository->all($pagination);
        $pagination->setTotal($characterCollection->count());
        return $characterCollection;
    }

    /**
     * @throws CharacterNotFoundException
     */
    public function detail($id): Character
    {
        return $this->characterRepository->find($id);
    }

    /**
     * @throws CharacterNotCreatedException
     * @throws CharacterNotFoundException
     */
    public function create($data): Character
    {
        return $this->characterRepository->create($data);
    }

    /**
     * @throws CharacterNotFoundException
     */
    public function update($id, $data): Character
    {
        return $this->characterRepository->update($id, $data);
    }

    /**
     * @throws CharacterNotFoundException
     */
    public function delete($id): bool
    {
        return $this->characterRepository->delete($id);
    }

}