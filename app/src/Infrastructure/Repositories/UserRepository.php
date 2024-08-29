<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\User;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Infrastructure\Exceptions\UserNotFoundException;
use App\Infrastructure\Exceptions\UserTokenCannotCreateException;
use App\Infrastructure\Services\UserSessionTokenGenerator;
use Firebase\JWT\JWT;

class UserRepository implements UserRepositoryInterface
{

    function __construct(
        private \PDO $connection
    )
    {
    }

    /**
     * @throws UserNotFoundException
     */
    public function find($name): User
    {
        $statement = $this->connection->prepare("SELECT * FROM users WHERE user_name = :name");
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
        $jwt = UserSessionTokenGenerator::generate($user);

        $statement = $this->connection->prepare("UPDATE users SET user_token = :token WHERE id = :id");
        $statement->execute(['token' => $jwt, 'id' => $user->id]);

        if ($statement->rowCount() === 0) {
            throw new UserTokenCannotCreateException();
        }

        return $jwt;
    }
}