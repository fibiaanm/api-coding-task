<?php

namespace App\UI\Http\Controllers\Factions;

use App\Application\Services\FactionsService;
use App\Infrastructure\Exceptions\FactionNotCreatedException;
use App\Infrastructure\Exceptions\FactionNotFoundException;
use App\UI\Http\Responses\ResponseBuilder;
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
            return ResponseBuilder::success($faction);
        } catch (FactionNotCreatedException $e) {
            return ResponseBuilder::serverError('Faction not created');
        } catch (FactionNotFoundException $e) {
            return ResponseBuilder::notFound('Faction not found');
        }
    }

}