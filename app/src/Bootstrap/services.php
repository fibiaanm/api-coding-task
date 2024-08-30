<?php

use App\Application\Services\CharacterService;
use App\Application\Services\EquipmentService;
use App\Application\Services\FactionsService;
use App\Application\Services\UserService;
use App\Domain\Repositories\CharacterRepositoryInterface;
use App\Domain\Repositories\EquipmentRepositoryInterface;
use App\Domain\Repositories\FactionRepositoryInterface;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Infrastructure\Services\AuthenticatedUserService;
use App\Infrastructure\Services\UserSessionTokenGenerator;
use App\Loaders\SecretsManager;

/**
 * @var \DI\Container $container
 */
$container->set(UserSessionTokenGenerator::class, function () use ($container) {
    return new UserSessionTokenGenerator(
        $container->get(SecretsManager::class)
    );
});

$container->set(FactionsService::class, function () use ($container) {
    return new FactionsService(
        $container->get(FactionRepositoryInterface::class)
    );
});
$container->set(CharacterService::class, function () use ($container) {
    return new CharacterService(
        $container->get(CharacterRepositoryInterface::class)
    );
});
$container->set(EquipmentService::class, function () use ($container) {
    return new EquipmentService(
        $container->get(EquipmentRepositoryInterface::class)
    );
});
$container->set(UserService::class, function () use ($container) {
    return new UserService(
        $container->get(UserRepositoryInterface::class),
        $container->get(AuthenticatedUserService::class)
    );
});