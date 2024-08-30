<?php

namespace App\Bootstrap;

use App\Infrastructure\Persistence\DatabaseConnection;
use App\Infrastructure\Persistence\RedisConnection;
use App\Infrastructure\Services\AuthenticatedUserService;
use App\Loaders\SecretsManager;

/**
 * @var \DI\Container $container
 */
$container->set(SecretsManager::class, function () {
    return SecretsManager::build();
});
$container->set(\PDO::class, function () use ($container) {
    return DatabaseConnection::connect(
        $container->get(SecretsManager::class)
    );
});
$container->set(\Redis::class, function () use ($container) {
    return RedisConnection::connect(
        $container->get(SecretsManager::class)
    );
});
$container->set(AuthenticatedUserService::class, function () {
    return new AuthenticatedUserService();
});
