<?php

namespace App\Infrastructure\Persistence;

use App\Loaders\SecretsManager;

class RedisConnection
{
    /**
     * @throws \RedisException
     */
    static function connect(
        SecretsManager $secrets
    ): \Redis {
        $redis = new \Redis();
        $redis->connect(
            $secrets->secrets['redis']['host'],
            $secrets->secrets['redis']['port']
        );
        return $redis;
    }
}