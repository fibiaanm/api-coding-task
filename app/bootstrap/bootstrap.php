<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Application\Services\FactionsService;
use App\Application\Services\UserService;
use App\Application\Services\CacheDecoratorService;
use App\Domain\Repositories\FactionRepositoryInterface;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Infrastructure\Persistence\DatabaseConnection;
use App\Infrastructure\Persistence\RedisConnection;
use App\Infrastructure\Repositories\FactionRepository;
use App\Infrastructure\Repositories\UserRepository;
use App\Infrastructure\Services\UserSessionTokenGenerator;
use App\Infrastructure\Services\AuthenticatedUserService;
use App\Loaders\SecretsManager;
use DI\Container;
use Slim\Factory\AppFactory;

$container = new Container();
$GLOBALS['container'] = $container;

require __DIR__ . '/helpers.php';

$container->set(SecretsManager::class, function () {
    return SecretsManager::build();
});
$container->set(PDO::class, function () use ($container) {
    return DatabaseConnection::connect(
        $container->get(SecretsManager::class)
    );
});
$container->set(Redis::class, function () use ($container) {
    return RedisConnection::connect(
        $container->get(SecretsManager::class)
    );
});

$container->set(AuthenticatedUserService::class, function () {
    return new AuthenticatedUserService();
});


$container->set(UserSessionTokenGenerator::class, function () use ($container) {
    return new UserSessionTokenGenerator(
        $container->get(SecretsManager::class)
    );
});
$container->set(FactionRepositoryInterface::class, function () use ($container) {
    return new CacheDecoratorService(
        $container->get(Redis::class),
        $container->get(SecretsManager::class),
        new FactionRepository(
            $container->get(PDO::class)
        )
    );
});
$container->set(FactionsService::class, function () use ($container) {
    return new FactionsService(
        $container->get(FactionRepositoryInterface::class)
    );
});

$container->set(UserRepositoryInterface::class, function () use ($container) {
    return new UserRepository(
        $container->get(PDO::class),
        $container->get(UserSessionTokenGenerator::class)
    );
});
$container->set(UserService::class, function () use ($container) {
    return new UserService(
        $container->get(UserRepositoryInterface::class),
        $container->get(AuthenticatedUserService::class)
    );
});

// Create the App instance and set the container
AppFactory::setContainer($container);
$app = AppFactory::create();

$app->add(function ($request, $handler) {
    $uri = $request->getUri();
    $path = $uri->getPath();

    // Remove trailing slash if not root
    if ($path != '/' && str_ends_with($path, '/')) {
        // Redirect permanently to URL without trailing slash
        $uri = $uri->withPath(rtrim($path, '/'));
        return $response = $handler->handle($request->withUri($uri))->withHeader('Location', (string)$uri)->withStatus(301);
    }

    return $handler->handle($request);
});

require __DIR__ . '/../src/UI/Http/Routes/api.php';
$app->run();