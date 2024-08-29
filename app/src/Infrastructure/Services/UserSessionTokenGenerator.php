<?php

namespace App\Infrastructure\Services;

use App\Domain\Entities\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class UserSessionTokenGenerator
{

    static string $key = "my_secret_key";

    static function generate(User $user): string
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

    static function decode(string $token): array
    {
        return (array) JWT::decode(
            $token,
            new Key(self::$key, "HS256"),
        );
    }

}