<?php

namespace App\UI\Http\Controllers\Characters;

use App\Application\Services\CharacterService;
use App\Infrastructure\Exceptions\CharacterNotFoundException;
use App\UI\Http\Responses\ResponseBuilder;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class DetailCharacterController
{

    public function __construct(
        private readonly CharacterService $characterService
    )
    {
    }

    public function __invoke(Request $request, Response $response, $args): Response
    {
        try {
            $character = $this->characterService->detail($args['id']);
            return ResponseBuilder::success($character->toArray());
        } catch (CharacterNotFoundException $e) {
            return ResponseBuilder::notFound($e->getMessage());
        }
    }

}