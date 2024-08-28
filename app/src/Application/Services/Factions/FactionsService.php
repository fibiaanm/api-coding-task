<?php

namespace App\Application\Services\Factions;

use App\Domain\Repositories\FactionRepositoryInterface;

class FactionsService
{
    public function __construct(
        private FactionRepositoryInterface $factionRepository
    )
    {
    }

    public function list()
    {
        return $this->factionRepository->all();
    }

    public function detail($id)
    {
        return $this->factionRepository->find($id);
    }

    public function create($data)
    {
        return $this->factionRepository->create($data);
    }

    public function update($id, $data)
    {
        return $this->factionRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->factionRepository->delete($id);
    }

}