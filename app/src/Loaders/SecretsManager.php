<?php

namespace App\Loaders;

use Dotenv\Dotenv;

class SecretsManager
{
    function __construct(
        public array $secrets
    )
    {
    }

    static function build(): SecretsManager
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();
        return new SecretsManager([
            'db' => [
                'host' => $_ENV['DB_HOST'],
                'user' => $_ENV['DB_USER'],
                'password' => $_ENV['DB_PASS'],
                'database' => $_ENV['DB_NAME'],
            ],
            'jwt' => [
                'key' => $_ENV['JWT_KEY']
            ],
            'redis' => [
                'host' => $_ENV['REDIS_HOST'],
                'port' => $_ENV['REDIS_PORT'],
                'expire' => $_ENV['REDIS_EXPIRE'],
            ]
        ]);
    }

}