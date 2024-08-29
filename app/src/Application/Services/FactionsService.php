<?php

namespace App\Application\Services;

use App\Application\DataObjects\PaginationObject;
use App\Domain\Entities\Faction;
use App\Domain\Entities\FactionCollection;
use App\Domain\Repositories\FactionRepositoryInterface;
use App\Infrastructure\Exceptions\FactionNotCreatedException;
use App\Infrastructure\Exceptions\FactionNotFoundException;
use App\Infrastructure\Exceptions\FactionsNotFoundException;

class FactionsService
{
    public function __construct(
        /**
         * @var FactionRepositoryInterface
         */
        private readonly CacheDecoratorService $factionRepository
    ) {
    }

    /**
     * @throws FactionsNotFoundException
     */
    public function list(PaginationObject $pagination): FactionCollection
    {
        $factionCollection = $this->factionRepository->all($pagination);
        $pagination->setTotal($factionCollection->count());
        return $factionCollection;
    }

    /**
     * @throws FactionNotFoundException
     */
    public function detail($id): Faction
    {
        return $this->factionRepository->find($id);
    }

    /**
     * @throws FactionNotFoundException
     * @throws FactionNotCreatedException
     */
    public function create($data): Faction
    {
        return $this->factionRepository->create($data);
    }

    /**
     * @throws FactionNotFoundException
     */
    public function update($id, $data): Faction
    {
        return $this->factionRepository->update($id, $data);
    }

    /**
     * @throws FactionNotFoundException
     */
    public function delete($id): bool
    {
        return $this->factionRepository->delete($id);
    }

}