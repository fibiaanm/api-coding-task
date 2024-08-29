<?php

namespace App\UI\Http\Controllers\Factions;

use App\Application\Services\FactionsService;
use App\Infrastructure\Exceptions\FactionsNotFoundException;
use App\UI\Http\Responses\ResponseBuilder;
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
            $factions =$this->factionsService->list();
            return ResponseBuilder::success($factions->toArray());
        } catch (FactionsNotFoundException $e) {
            return ResponseBuilder::notFound('Factions not found');
        } catch (\Exception $e) {
            return ResponseBuilder::serverError('Internal server error');
        }
    }

}