<?php

namespace App\Bootstrap;

use App\Application\Services\CacheDecoratorService;
use App\Domain\Repositories\CharacterRepositoryInterface;
use App\Domain\Repositories\EquipmentRepositoryInterface;
use App\Domain\Repositories\FactionRepositoryInterface;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Infrastructure\Repositories\CharacterRepository;
use App\Infrastructure\Repositories\EquipmentRepository;
use App\Infrastructure\Repositories\FactionRepository;
use App\Infrastructure\Repositories\UserRepository;
use App\Infrastructure\Services\UserSessionTokenGenerator;
use App\Loaders\SecretsManager;
use \PDO;
use \Redis;

/**
 * @var \DI\Container $container
 */
$container->set(FactionRepositoryInterface::class, function () use ($container) {
    return new CacheDecoratorService(
        $container->get(Redis::class),
        $container->get(SecretsManager::class),
        new FactionRepository(
            $container->get(PDO::class)
        )
    );
});
$container->set(CharacterRepositoryInterface::class, function () use ($container) {
    return new CacheDecoratorService(
        $container->get(Redis::class),
        $container->get(SecretsManager::class),
        new CharacterRepository(
            $container->get(PDO::class)
        )
    );
});
$container->set(EquipmentRepositoryInterface::class, function () use ($container) {
    return new CacheDecoratorService(
        $container->get(Redis::class),
        $container->get(SecretsManager::class),
        new EquipmentRepository(
            $container->get(PDO::class)
        )
    );
});
$container->set(UserRepositoryInterface::class, function () use ($container) {
    return new UserRepository(
        $container->get(PDO::class),
        $container->get(UserSessionTokenGenerator::class)
    );
});