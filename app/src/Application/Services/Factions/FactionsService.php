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

}