<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Faction;
use App\Domain\Entities\FactionCollection;
use App\Infrastructure\Exceptions\FactionNotCreatedException;
use App\Infrastructure\Exceptions\FactionNotFoundException;
use App\Infrastructure\Exceptions\FactionsNotFoundException;

interface FactionRepositoryInterface
{
    /**
     * @throws FactionsNotFoundException
     */
    public function all(): FactionCollection;
    /**
     * @throws FactionNotFoundException
     */
    public function find($id): Faction;
    /**
     * @throws FactionNotFoundException
     * @throws FactionNotCreatedException
     */
    public function create($data);
    /**
     * @throws FactionNotFoundException
     */
    public function update($id, $data);
    /**
     * @throws FactionNotFoundException
     */
    public function delete($id);
}