<?php

namespace App\UI\Http\Controllers\Factions;

use App\Application\Services\FactionsService;
use App\Infrastructure\Exceptions\FactionNotCreatedException;
use App\Infrastructure\Exceptions\FactionNotFoundException;
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
        try {
            $dataFromRequest = $request->getBody();
            $dataFromRequest = json_decode($dataFromRequest, true);

            $faction = $this->factionsService->create($dataFromRequest);

            $response->getBody()->write(json_encode($faction, JSON_UNESCAPED_UNICODE));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (FactionNotCreatedException $e) {
            $response->getBody()->write(json_encode(['error' => 'Faction not created'], JSON_UNESCAPED_UNICODE));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        } catch (FactionNotFoundException $e) {
            $response->getBody()->write(json_encode(['error' => 'No faction found'], JSON_UNESCAPED_UNICODE));
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        }
    }

}