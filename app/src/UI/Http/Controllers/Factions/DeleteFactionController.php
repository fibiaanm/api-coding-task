<?php

namespace App\UI\Http\Controllers\Factions;

use App\Application\Services\FactionsService;
use App\Infrastructure\Exceptions\FactionNotFoundException;
use App\UI\Http\Responses\ResponseBuilder;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use OpenApi\Attributes as OA;

class DeleteFactionController
{

    public function __construct(
        private FactionsService $factionsService
    )
    {

    }


    #[OA\Delete(
        path: '/api/factions/{id}',
        summary: 'Delete a specific faction by ID',
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'ID of the faction to delete',
                in: 'path',
                required: true,
                schema: new OA\Schema(
                    type: 'integer',
                    format: 'int64',
                    example: 1
                )
            ),
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
                response: 200,
                description: 'Successful deletion of the faction',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'string', example: 'success'),
                        new OA\Property(property: 'message', type: 'string', example: 'Faction deleted')
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Faction not found',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/ResourceNotFoundResponse'
                )
            ),
            new OA\Response(
                response: 401,
                description: 'Unauthorized access',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/UnauthorizedResponse'
                )
            ),
            new OA\Response(
                response: 403,
                description: 'Forbidden access',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/ForbiddenResponse'
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
                response: 500,
                description: 'Internal Server Error',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/ServerErrorResponse'
                )
            )
        ]
    )]
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