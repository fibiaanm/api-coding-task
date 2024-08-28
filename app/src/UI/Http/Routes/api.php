<?php


use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Psr7\Response;
use \Slim\Routing\RouteCollectorProxy;
use App\UI\Http\Controllers\Factions\ListFactionsController;
use App\UI\Http\Controllers\Factions\DetailFactionController;
use App\UI\Http\Controllers\Factions\CreateFactionController;
use \App\UI\Http\Controllers\Api\HomeController;

/**
 * @var \Slim\App $app
 */

$app->group('/api', function (RouteCollectorProxy $group) {
    $group->get('', HomeController::class);

    $group->group('/factions', function (RouteCollectorProxy $group) {

        $group->get('', ListFactionsController::class);
        $group->get('/{id:[0-9]+}', DetailFactionController::class);

        $group->post('', CreateFactionController::class);
    });

});

$app->get('/', function (Request $request, Response $response) {
    $data = [
        'name' => 'Slim Framework',
        'version' => '4.0'
    ];
    $response->getBody()->write(json_encode($data));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->get('/test', ListFactionsController::class);
