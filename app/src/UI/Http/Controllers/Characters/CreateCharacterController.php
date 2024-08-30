<?php

namespace App\UI\Http\Controllers\Characters;

use App\Application\Services\CharacterService;
use App\Infrastructure\Exceptions\CharacterNotCreatedException;
use App\Infrastructure\Exceptions\CharacterNotFoundException;
use App\UI\Http\Responses\ResponseBuilder;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use OpenApi\Attributes as OA;

class CreateCharacterController
{

    public function __construct(
        private readonly CharacterService $characterService
    )
    {
    }

    #[OA\Post(
        path: '/api/character',
        summary: 'Create a new character',
        requestBody: new OA\RequestBody(
            description: 'Character creation payload',
            required: true,
            content: new OA\JsonContent(
                ref: '#/components/schemas/CharacterPayload'
            )
        ),
        parameters: [
            new OA\Parameter(
                name: 'Authorization',
                description: 'Bearer token for authorization',
                in: 'header',
                required: true,
                schema: new OA\Schema(
                    type: 'string',
                    example: 'Bearer <your-token-here>'
                )
            )
        ],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Successful character creation',
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
                response: 422,
                description: 'Validation error for the input data',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/ValidationError'
                )
            ),
            new OA\Response(
                response: 401,
                description: 'Unauthorized access',
                content: new OA\JsonContent(ref: '#/components/schemas/UnauthorizedResponse')
            ),
            new OA\Response(
                response: 403,
                description: 'Forbidden access',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/ForbiddenResponse'
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Resource not found',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/ResourceNotFoundResponse'
                )
            ),
            new OA\Response(
                response: 500,
                description: 'Internal Server Error',
                content: new OA\JsonContent(ref: '#/components/schemas/ServerErrorResponse')
            )
        ]
    )]
    public function __invoke(Request $request, Response $response): Response
    {
        try {
            $encodedData = $request->getBody();
            $data = json_decode($encodedData, true);
            $character = $this->characterService->create($data);
            return ResponseBuilder::created($character->toArray());
        } catch (CharacterNotFoundException|CharacterNotCreatedException $e) {
            return ResponseBuilder::notFound($e->getMessage());
        }
    }

}