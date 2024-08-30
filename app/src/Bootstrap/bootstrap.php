<?php

namespace App\Bootstrap;

require_once __DIR__ . '/../../vendor/autoload.php';

use DI\Container;
use Slim\Factory\AppFactory;


try {

    $container = new Container();
    $GLOBALS['container'] = $container;

    require __DIR__ . '/helpers.php';
    require __DIR__ . '/repositories.php';
    require __DIR__ . '/connections.php';
    require __DIR__ . '/services.php';

// Create the App instance and set the container
    AppFactory::setContainer($container);
    $app = AppFactory::create();

    $app->add(function ($request, $handler) {
        $uri = $request->getUri();
        $path = $uri->getPath();
        error_log($path);

        if ($path != '/' && str_ends_with($path, '/')) {
            $uri = $uri->withPath(rtrim($path, '/'));
            return $response = $handler->handle($request->withUri($uri))->withHeader('Location', (string)$uri)->withStatus(301);
        }

        return $handler->handle($request);
    });

    require __DIR__ . '/../../src/UI/Http/Routes/api.php';

}catch (\Slim\Exception\HttpNotFoundException $e) {
    http_response_code(404);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Route not found'], JSON_UNESCAPED_UNICODE);
}catch (\Slim\Exception\HttpMethodNotAllowedException $e) {
    http_response_code(405);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Method not allowed'], JSON_UNESCAPED_UNICODE);
}
catch (\Exception $e) {
    error_log($e->getMessage());
    http_response_code(500);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Internal crucial server error'], JSON_UNESCAPED_UNICODE);
}
