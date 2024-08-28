<?php

namespace App\UI\Http\Controllers\Factions;

use App\Application\Services\Factions\FactionsService;
use App\Infrastructure\Exceptions\FactionNotFoundException;
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
            error_log('running');
            $response->getBody()->write(json_encode([
                'deleted' => $deleted
            ], JSON_UNESCAPED_UNICODE));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (FactionNotFoundException $e) {
            $response->getBody()->write(json_encode(['error' => 'Faction not found'], JSON_UNESCAPED_UNICODE));
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode(['error' => 'Internal server error'], JSON_UNESCAPED_UNICODE));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }

}