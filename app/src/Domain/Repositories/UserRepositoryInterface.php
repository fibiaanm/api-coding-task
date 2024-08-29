<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\User;
use App\Infrastructure\Exceptions\UserNotFoundException;
use App\Infrastructure\Exceptions\UserTokenCannotCreateException;

interface UserRepositoryInterface
{
    /**
     * @param $name
     * @return mixed
     * @throws UserNotFoundException
     */
    public function find($name): User;
    /**
     * @throws UserTokenCannotCreateException
     */
    public function createToken(User $user): string;
}