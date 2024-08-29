<?php


use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Psr7\Response;
use \Slim\Routing\RouteCollectorProxy;
use App\UI\Http\Controllers\Factions\ListFactionsController;
use App\UI\Http\Controllers\Factions\DetailFactionController;
use App\UI\Http\Controllers\Factions\CreateFactionController;
use \App\UI\Http\Controllers\Api\HomeController;
use App\UI\Http\Controllers\Factions\UpdateFactionController;
use App\UI\Http\Controllers\Factions\DeleteFactionController;
use App\UI\Http\Controllers\Users\LoginController;
use App\UI\Http\Middlewares\AuthMiddleware;

/**
 * @var \Slim\App $app
 */
$app->group('/api', function (RouteCollectorProxy $apiGroup) {
    $apiGroup->get('', HomeController::class)
        ->add(AuthMiddleware::class);

    $apiGroup->group('/factions', function (RouteCollectorProxy $factions) {
        $factions->get('', ListFactionsController::class);
        $factions->get('/{id:[0-9]+}', DetailFactionController::class);

        $factions->group('', function (RouteCollectorProxy $factions) {
            $factions->post('', CreateFactionController::class);
            $factions->put('/{id:[0-9]+}', UpdateFactionController::class);
            $factions->delete('/{id:[0-9]+}', DeleteFactionController::class);
        })->add(AuthMiddleware::class);
    });
});

/**
 * TODO: Implementar validadoress
 * TODO: Builder de responses
 * TODO: Implementar autorización
 * TODO: Implementar caché
 * TODO: Implementar documentación
 * TODO: Singletón autenticación
 */

$app->group('/auth', function (RouteCollectorProxy $group) {
    $group->post('/login', LoginController::class);
});

$app->get('', function (Request $request, Response $response) {
    phpinfo();
    $response->withHeader('Content-Type', 'text/html');
});

$app->get('/test', ListFactionsController::class);
