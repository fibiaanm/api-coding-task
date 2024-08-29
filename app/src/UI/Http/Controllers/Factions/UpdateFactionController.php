<?php

namespace App\UI\Http\Controllers\Factions;

use App\Application\Services\FactionsService;
use App\Infrastructure\Exceptions\FactionNotFoundException;
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
        try {
            $dataFromRequest = $request->getBody();
            $dataFromRequest = json_decode($dataFromRequest, true);

            $faction = $this->factionsService->update($args['id'], $dataFromRequest);

            $response->getBody()->write(json_encode($faction, JSON_UNESCAPED_UNICODE));
            return $response->withHeader('Content-Type', 'application/json');

        } catch (FactionNotFoundException $e) {
            $response->getBody()->write(json_encode(['error' => 'Faction not found'], JSON_UNESCAPED_UNICODE));
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        }
    }

}