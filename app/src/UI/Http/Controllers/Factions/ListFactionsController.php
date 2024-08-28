<?php

namespace App\UI\Http\Controllers\Factions;

use App\Application\Services\Factions\FactionsService;
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
        $statement =$this->factionsService->list();
        $dat = json_encode($statement, JSON_UNESCAPED_UNICODE);

        $response->getBody()->write($dat);
        return $response->withHeader('Content-Type', 'application/json; charset=utf-8');

    }

}