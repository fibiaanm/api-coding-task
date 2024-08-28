<?php
use Slim\Factory\AppFactory;
use DI\Container;
use App\Infrastructure\Persistence\DatabaseConnection;
use App\Domain\Repositories\FactionRepositoryInterface;
use App\Infrastructure\Repositories\FactionRepository;
use App\Application\Services\Factions\FactionsService;

require_once __DIR__ . '/../vendor/autoload.php';

$container = new Container();

$container->set(PDO::class, function () {
    return DatabaseConnection::connect();
});
$container->set(FactionRepositoryInterface::class, function () use ($container) {
    return new FactionRepository(
        $container->get(PDO::class)
    );
});
$container->set(FactionsService::class, function () use ($container) {
    return new FactionsService(
        $container->get(FactionRepositoryInterface::class)
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