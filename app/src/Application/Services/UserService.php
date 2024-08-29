<?php

namespace App\Application\Services;

use App\Application\Exceptions\InvalidUserPasswordException;
use App\Domain\Entities\User;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Infrastructure\Exceptions\UserNotFoundException;
use App\Infrastructure\Exceptions\UserTokenCannotCreateException;

class UserService
{
    function __construct(
        private UserRepositoryInterface $userRepository
    )
    {
    }

    /**
     * @throws UserNotFoundException
     */
    public function find($name): User
    {
        return $this->userRepository->find($name);
    }

    /**
     * @throws UserNotFoundException
     * @throws InvalidUserPasswordException
     * @throws UserTokenCannotCreateException
     */
    public function login($name, $password): User
    {
        $user = $this->userRepository->find($name);
        $valid = $user->validatePassword($password);
        if (!$valid) {
            throw new InvalidUserPasswordException($name);
        }
        $token = $this->userRepository->createToken($user);
        $user->setToken($token);
        return $user;
    }


}