<?php

namespace App\UI\Http\Controllers\Characters;

use App\Application\Services\CharacterService;
use App\Infrastructure\Exceptions\CharacterNotFoundException;
use App\UI\Http\Responses\ResponseBuilder;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use OpenApi\Attributes as OA;

class DetailCharacterController
{

    public function __construct(
        private readonly CharacterService $characterService
    )
    {
    }

    #[OA\Get(
        path: '/api/characters/{id}',
        summary: 'Get a specific faction by ID',
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'ID of the character to retrieve',
                in: 'path',
                required: true,
                schema: new OA\Schema(
                    type: 'integer',
                    format: 'int64',
                    example: 1
                )
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successful response with faction details',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'string', example: 'success'),
                        new OA\Property(
                            ref: '#/components/schemas/Character'
                        )
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Faction not found',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'string', example: 'error'),
                        new OA\Property(property: 'message', type: 'string', example: 'Character not found')
                    ]
                )
            ),
            new OA\Response(
                response: 500,
                description: 'Internal Server Error',
                content: new OA\JsonContent(ref: '#/components/schemas/ServerErrorResponse')
            )
        ]
    )]
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