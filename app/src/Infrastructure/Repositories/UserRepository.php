<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\User;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Infrastructure\Exceptions\UserNotFoundException;
use App\Infrastructure\Exceptions\UserTokenCannotCreateException;
use App\Infrastructure\Exceptions\UserTokenExpired;
use App\Infrastructure\Exceptions\UserTokenInvalidException;
use App\Infrastructure\Services\UserSessionTokenGenerator;

class UserRepository implements UserRepositoryInterface
{
    public string $table = 'users';

    function __construct(
        private \PDO $connection,
        private UserSessionTokenGenerator $tokenGenerator,
    ) {
    }

    /**
     * @throws UserNotFoundException
     */
    public function find($name): User
    {
        $statement = $this->connection->prepare("SELECT * FROM $this->table WHERE user_name = :name");
        $statement->execute(['name' => $name]);
        $userFetched = $statement->fetch();

        if (!$userFetched) {
            throw new UserNotFoundException($name);
        }

        return User::fromSqlResponse($userFetched);
    }

    /**
     * @throws UserTokenCannotCreateException
     */
    public function createToken(User $user): string
    {
        $jwt = $this->tokenGenerator->generate($user);

        $statement = $this->connection->prepare("UPDATE $this->table SET user_token = :token WHERE id = :id");
        $statement->execute(['token' => $jwt, 'id' => $user->id]);


        if ($statement->rowCount() === 0) {
            throw new UserTokenCannotCreateException();
        }

        return $jwt;
    }

    /**
     * @throws UserNotFoundException
     * @throws UserTokenExpired
     * @throws UserTokenInvalidException
     */
    public function findByToken($token): User
    {
        $decoded = $this->tokenGenerator->decode($token);

        $statement = $this->connection->prepare("SELECT * FROM $this->table WHERE user_token = :token");
        $statement->execute(['token' => $token]);
        $userFetched = $statement->fetch();

        if (!$userFetched) {
            throw new UserNotFoundException($token);
        }

        return User::fromSqlResponse($userFetched);
    }
}