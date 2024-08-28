<?php

namespace App\UI\Http\Controllers\Factions;

use App\Application\Services\Factions\FactionsService;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class UpdateFactionController
{
    public function __construct(
        private FactionsService $factionsService
    )
    {
    }

    public function __invoke(Request $request, Response $response, $args): Response
    {
        $dataFromRequest = $request->getBody();
        $dataFromRequest = json_decode($dataFromRequest, true);

        $faction = $this->factionsService->update($args['id'], $dataFromRequest);

        $response->getBody()->write(json_encode($faction, JSON_UNESCAPED_UNICODE));
        return $response->withHeader('Content-Type', 'application/json');
    }

}