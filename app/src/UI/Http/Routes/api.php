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

/**
 * @var \Slim\App $app
 */
$app->group('/api', function (RouteCollectorProxy $group) {
    $group->get('', HomeController::class);

    $group->group('/factions', function (RouteCollectorProxy $group) {

        $group->get('', ListFactionsController::class);
        $group->get('/{id:[0-9]+}', DetailFactionController::class);

        $group->post('', CreateFactionController::class);
        $group->put('/{id:[0-9]+}', UpdateFactionController::class);
        $group->delete('/{id:[0-9]+}', DeleteFactionController::class);
    });

});

$app->get('', function (Request $request, Response $response) {
    phpinfo();
    $response->withHeader('Content-Type', 'text/html');
});

$app->get('/test', ListFactionsController::class);
