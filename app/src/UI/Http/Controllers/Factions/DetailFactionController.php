<?php

namespace App\UI\Http\Controllers\Factions;

use App\Application\Services\FactionsService;
use App\Infrastructure\Exceptions\FactionNotFoundException;
use App\UI\Http\Responses\ResponseBuilder;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class DetailFactionController
{
    function __construct(
        private FactionsService $factionsService
    )
    {
    }

    public function __invoke(Request $request, Response $response, $args): Response
    {
        try {
            $data = $this->factionsService->detail($args['id']);

            return ResponseBuilder::success($data->toArray());
        } catch (FactionNotFoundException $e) {
            return ResponseBuilder::notFound('Faction not found');
        }
    }
}