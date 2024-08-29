<?php

namespace App\UI\Http\Controllers\Factions;

use App\Application\Services\FactionsService;
use App\Infrastructure\Exceptions\FactionNotFoundException;
use App\UI\Http\Responses\ResponseBuilder;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

use OpenApi\Attributes as OA;

class DetailFactionController
{
    function __construct(
        private FactionsService $factionsService
    )
    {
    }

    #[OA\Get(
        path: '/api/factions/{id}',
        summary: 'Get a specific faction by ID',
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'ID of the faction to retrieve',
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
                            ref: '#/components/schemas/Factions'
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
                        new OA\Property(property: 'message', type: 'string', example: 'Faction not found')
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
            $data = $this->factionsService->detail($args['id']);

            return ResponseBuilder::success($data->toArray());
        } catch (FactionNotFoundException $e) {
            return ResponseBuilder::notFound('Faction not found');
        }
    }
}