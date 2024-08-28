<?php
use Slim\Factory\AppFactory;
use DI\Container;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/ConnectDatabase.php';

$container = new Container();

$container->set(PDO::class, function () {
    return ConnectDatabase::connect();
});

// Create the App instance and set the container
AppFactory::setContainer($container);
$app = AppFactory::create();
require __DIR__ . '/../src/UI/Http/Routes/api.php';
$app->run();