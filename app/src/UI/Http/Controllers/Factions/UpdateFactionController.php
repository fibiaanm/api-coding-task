<?php

namespace App\UI\Http\Controllers\Factions;

use App\Application\Services\FactionsService;
use App\Infrastructure\Exceptions\FactionNotFoundException;
use App\UI\Http\Responses\ResponseBuilder;
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

            return ResponseBuilder::success($faction);

        } catch (FactionNotFoundException $e) {
            return ResponseBuilder::notFound('Faction not found');
        }
    }

}