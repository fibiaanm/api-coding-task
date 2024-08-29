<?php

namespace App\Infrastructure\Services;

use App\Domain\Entities\User;
use App\Infrastructure\Exceptions\UserTokenExpired;
use App\Infrastructure\Exceptions\UserTokenInvalidException;
use App\Loaders\SecretsManager;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class UserSessionTokenGenerator
{

    static string $key = "";

    public function __construct(
        SecretsManager $secrets
    ) {
        self::$key = $secrets->secrets['jwt']['key'];
    }


    public function generate(User $user): string
    {
        $expiration = time() + 3600;
        $data = [
            'iat' => time(),
            'exp' => $expiration,
            'id' => $user->id,
            'name' => $user->name
        ];
        return JWT::encode($data, self::$key, "HS256");
    }

    /**
     * @throws UserTokenExpired
     * @throws UserTokenInvalidException
     */
    public function decode(string $token): array
    {
        try {
            $data = (array) JWT::decode(
                $token,
                new Key(self::$key, "HS256"),
            );
        } catch (\Exception $e) {
            throw new UserTokenInvalidException();
        }


        if ($data['exp'] < time()) {
            throw new UserTokenExpired();
        }

        return $data;
    }

}