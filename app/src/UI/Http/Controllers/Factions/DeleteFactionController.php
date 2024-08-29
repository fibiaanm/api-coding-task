<?php

namespace App\UI\Http\Controllers\Factions;

use App\Application\Services\FactionsService;
use App\Infrastructure\Exceptions\FactionNotFoundException;
use App\UI\Http\Responses\ResponseBuilder;
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
        try {
            $deleted = $this->factionsService->delete($args['id']);

            if ($deleted) {
                return ResponseBuilder::success(['message' => 'Faction deleted']);
            } else {
                return ResponseBuilder::success(['message' => 'No faction to delete']);
            }
        } catch (FactionNotFoundException $e) {
            return ResponseBuilder::notFound('Faction not found');
        } catch (\Exception $e) {
            return ResponseBuilder::serverError('Internal server error');
        }
    }

}