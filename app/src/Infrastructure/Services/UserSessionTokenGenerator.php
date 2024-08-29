<?php

namespace App\Infrastructure\Services;

use App\Domain\Entities\User;
use App\Loaders\SecretsManager;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class UserSessionTokenGenerator
{

    static string $key = "";

    public function __construct(
        SecretsManager $secrets
    )
    {
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

    public function decode(string $token): array
    {
        return (array) JWT::decode(
            $token,
            new Key(self::$key, "HS256"),
        );
    }

}