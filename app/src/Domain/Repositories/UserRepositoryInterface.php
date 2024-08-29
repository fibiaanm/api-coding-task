<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\User;
use App\Infrastructure\Exceptions\UserNotFoundException;
use App\Infrastructure\Exceptions\UserTokenCannotCreateException;
use App\Infrastructure\Exceptions\UserTokenExpired;
use App\Infrastructure\Exceptions\UserTokenInvalidException;

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
    /**
     * @throws UserNotFoundException
     * @throws UserTokenExpired
     * @throws UserTokenInvalidException
     */
    public function findByToken(string $token): User;
}