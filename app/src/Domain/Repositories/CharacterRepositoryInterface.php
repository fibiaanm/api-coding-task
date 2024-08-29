<?php

namespace App\Domain\Repositories;

use App\Application\DataObjects\PaginationObject;
use App\Domain\Entities\Character;
use App\Domain\Entities\CharacterCollection;
use App\Infrastructure\Exceptions\CharacterNotCreatedException;
use App\Infrastructure\Exceptions\CharacterNotFoundException;
use App\Infrastructure\Exceptions\CharactersNotFoundException;

interface CharacterRepositoryInterface
{
    /**
     * @param PaginationObject $pagination
     * @return CharacterCollection
     * @throws CharactersNotFoundException
     */
    public function all(PaginationObject $pagination): CharacterCollection;

    /**
     * @param $id
     * @return Character
     * @throws CharacterNotFoundException
     */
    public function find($id): Character;

    /**
     * @param $data
     * @return Character
     * @throws CharacterNotFoundException
     * @throws CharacterNotCreatedException
     */
    public function create($data): Character;

    /**
     * @param $id
     * @param $data
     * @return Character
     * @throws CharacterNotFoundException
     */
    public function update($id, $data): Character;

    /**
     * @param $id
     * @return bool
     * @throws CharacterNotFoundException
     */
    public function delete($id): bool;

}