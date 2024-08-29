<?php

namespace App\UI\Http\Controllers\Factions;

use App\Application\Services\FactionsService;
use App\Infrastructure\Exceptions\FactionNotCreatedException;
use App\Infrastructure\Exceptions\FactionNotFoundException;
use App\UI\Http\Responses\ResponseBuilder;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

use OpenApi\Attributes as OA;

class CreateFactionController
{

    function __construct(
        private FactionsService $factionsService
    )
    {

    }

    #[OA\Post(
        path: '/api/factions',
        summary: 'Create a new faction',
        requestBody: new OA\RequestBody(
            description: 'Faction creation payload',
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'name', description: 'Name of the faction', type: 'string', example: 'El nombre de la facción'),
                    new OA\Property(property: 'description', description: 'Description of the faction', type: 'string', example: 'Es una facción en español, entonces necesita ñ y tíldes')
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successful faction creation',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'string', example: 'success'),
                        new OA\Property(
                            ref: '#/components/schemas/Factions'
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
            $dataFromRequest = $request->getBody();
            $dataFromRequest = json_decode($dataFromRequest, true);

            $faction = $this->factionsService->create($dataFromRequest);
            return ResponseBuilder::success($faction->toArray());
        } catch (FactionNotCreatedException $e) {
            return ResponseBuilder::serverError('Faction not created');
        } catch (FactionNotFoundException $e) {
            return ResponseBuilder::notFound('Faction not found');
        }
    }

}