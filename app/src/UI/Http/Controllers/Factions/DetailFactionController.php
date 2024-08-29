<?php

namespace App\UI\Http\Controllers\Factions;

use App\Application\Services\FactionsService;
use App\Infrastructure\Exceptions\FactionNotFoundException;

class DetailFactionController
{
    function __construct(
        private FactionsService $factionsService
    )
    {
    }

    public function __invoke($request, $response, $args)
    {
        try {
            $data = $this->factionsService->detail($args['id']);

            $response->getBody()->write(json_encode($data->toArray(), JSON_UNESCAPED_UNICODE));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (FactionNotFoundException $e) {
            $response->getBody()->write(json_encode(['error' => 'Faction not found'], JSON_UNESCAPED_UNICODE));
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        }
    }
}