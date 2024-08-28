<?php

namespace App\Application\Services\Factions;

use App\Domain\Repositories\FactionRepositoryInterface;
use App\Infrastructure\Exceptions\FactionNotCreatedException;
use App\Infrastructure\Exceptions\FactionNotFoundException;
use App\Infrastructure\Exceptions\FactionsNotFoundException;

class FactionsService
{
    public function __construct(
        private FactionRepositoryInterface $factionRepository
    )
    {
    }

    /**
     * @throws FactionsNotFoundException
     */
    public function list()
    {
        return $this->factionRepository->all();
    }

    /**
     * @throws FactionNotFoundException
     */
    public function detail($id)
    {
        return $this->factionRepository->find($id);
    }

    /**
     * @throws FactionNotFoundException
     * @throws FactionNotCreatedException
     */
    public function create($data)
    {
        return $this->factionRepository->create($data);
    }

    /**
     * @throws FactionNotFoundException
     */
    public function update($id, $data)
    {
        return $this->factionRepository->update($id, $data);
    }

    /**
     * @throws FactionNotFoundException
     */
    public function delete($id)
    {
        return $this->factionRepository->delete($id);
    }

}