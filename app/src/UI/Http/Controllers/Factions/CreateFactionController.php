<?php

namespace App\UI\Http\Controllers\Factions;

use App\Application\Services\Factions\FactionsService;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class CreateFactionController
{

    function __construct(
        private FactionsService $factionsService
    )
    {

    }

    public function __invoke(Request $request, Response $response): Response
    {
        $dataFromRequest = $request->getBody();
        $dataFromRequest = json_decode($dataFromRequest, true);

        $faction = $this->factionsService->create($dataFromRequest);

        $response->getBody()->write(json_encode($faction, JSON_UNESCAPED_UNICODE));
        return $response->withHeader('Content-Type', 'application/json');
    }

}