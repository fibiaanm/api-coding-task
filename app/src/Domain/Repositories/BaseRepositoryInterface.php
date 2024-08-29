<?php

namespace App\Domain\Repositories;

use App\Application\DataObjects\PaginationObject;

interface BaseRepositoryInterface
{
    public function all(PaginationObject $pagination): array;
    public function find($id);
    public function delete($id);
}