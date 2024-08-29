<?php

namespace App\UI\Http\Controllers\Characters;

use App\Application\Services\CharacterService;
use App\Infrastructure\Exceptions\CharacterNotFoundException;
use App\UI\Http\Responses\ResponseBuilder;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class UpdateCharacterController
{

    public function __construct(
        private CharacterService $characterService
    )
    {
    }

    public function __invoke(Request $request, Response $response, $args): Response
    {
        try {
            $id = (int)$args['id'];
            $dataEncoded = $request->getBody();
            $data = json_decode($dataEncoded, true);
            $character = $this->characterService->update($id, $data);
            return ResponseBuilder::success($character->toArray());
        } catch (CharacterNotFoundException $e) {
            return ResponseBuilder::notFound($e->getMessage());
        } catch (\Exception $e) {
            return ResponseBuilder::serverError($e->getMessage());
        }
    }

}