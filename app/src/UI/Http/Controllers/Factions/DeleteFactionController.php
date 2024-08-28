<?php

namespace App\UI\Http\Controllers\Factions;

use App\Application\Services\Factions\FactionsService;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class DeleteFactionController
{

    public function __construct(
        private FactionsService $factionsService
    )
    {

    }

    public function __invoke(Request $request, Response $response, $args): Response
    {
        $deleted = $this->factionsService->delete($args['id']);

        $response->getBody()->write(json_encode([
            'deleted' => $deleted
        ], JSON_UNESCAPED_UNICODE));
        return $response->withHeader('Content-Type', 'application/json');
    }

}