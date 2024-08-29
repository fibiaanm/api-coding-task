<?php

namespace App\UI\Http\Controllers\Characters;

use App\Application\Services\CharacterService;
use App\Infrastructure\Exceptions\CharacterNotCreatedException;
use App\Infrastructure\Exceptions\CharacterNotFoundException;
use App\UI\Http\Responses\ResponseBuilder;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class CreateCharacterController
{

    public function __construct(
        private readonly CharacterService $characterService
    )
    {
    }

    public function __invoke(Request $request, Response $response, $args): Response
    {
        try {
            $encodedData = $request->getBody();
            $data = json_decode($encodedData, true);
            $character = $this->characterService->create($data);
            return ResponseBuilder::success($character->toArray());
        } catch (CharacterNotFoundException|CharacterNotCreatedException $e) {
            return ResponseBuilder::notFound($e->getMessage());
        }
    }

}