<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Application\Services\FactionsService;
use App\Application\Services\CharacterService;
use App\Application\Services\UserService;
use App\Application\Services\EquipmentService;
use App\Application\Services\CacheDecoratorService;
use App\Domain\Repositories\FactionRepositoryInterface;
use App\Domain\Repositories\CharacterRepositoryInterface;
use App\Domain\Repositories\EquipmentRepositoryInterface;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Infrastructure\Persistence\DatabaseConnection;
use App\Infrastructure\Persistence\RedisConnection;
use App\Infrastructure\Repositories\FactionRepository;
use App\Infrastructure\Repositories\EquipmentRepository;
use App\Infrastructure\Repositories\UserRepository;
use App\Infrastructure\Repositories\CharacterRepository;
use App\Infrastructure\Services\UserSessionTokenGenerator;
use App\Infrastructure\Services\AuthenticatedUserService;
use App\Loaders\SecretsManager;
use DI\Container;
use Slim\Factory\AppFactory;


try {

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
        error_log($path);

        // Remove trailing slash if not root
        if ($path != '/' && str_ends_with($path, '/')) {
            // Redirect permanently to URL without trailing slash
            $uri = $uri->withPath(rtrim($path, '/'));
            return $response = $handler->handle($request->withUri($uri))->withHeader('Location', (string)$uri)->withStatus(301);
        }

        return $handler->handle($request);
    });

    require __DIR__ . '/../src/UI/Http/Routes/api.php';

}catch (\Slim\Exception\HttpNotFoundException $e) {
    http_response_code(404);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Route not found'], JSON_UNESCAPED_UNICODE);
}catch (\Slim\Exception\HttpMethodNotAllowedException $e) {
    http_response_code(405);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Method not allowed'], JSON_UNESCAPED_UNICODE);
}
catch (Exception $e) {
    error_log($e->getMessage());
    http_response_code(500);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Internal crucial server error'], JSON_UNESCAPED_UNICODE);
}
