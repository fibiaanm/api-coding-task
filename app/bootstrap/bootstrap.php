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
require __DIR__ . '/../src/UI/Http/Routes/api.php';
$app->run();