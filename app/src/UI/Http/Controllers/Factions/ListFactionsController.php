<?php

namespace App\UI\Http\Controllers\Factions;

use App\Application\Services\FactionsService;
use App\Infrastructure\Exceptions\FactionsNotFoundException;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class ListFactionsController
{

    function __construct(
        private FactionsService $factionsService
    )
    {

    }

    public function __invoke(Request $request, Response $response): Response
    {
        try {
            $statement =$this->factionsService->list();
            $dat = json_encode($statement, JSON_UNESCAPED_UNICODE);

            $response->getBody()->write($dat);
            return $response->withHeader('Content-Type', 'application/json; charset=utf-8');
        } catch (FactionsNotFoundException $e) {
            $response->getBody()->write(json_encode(['error' => 'No factions found'], JSON_UNESCAPED_UNICODE));
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json; charset=utf-8');

        }

    }

}