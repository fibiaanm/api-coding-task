<?php

namespace App\UI\Http\Controllers\Equipments;

use App\Application\Services\EquipmentService;
use App\Infrastructure\Exceptions\EquipmentNotFoundException;
use App\UI\Http\Responses\ResponseBuilder;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use OpenApi\Attributes as OA;

class UpdateEquipmentController
{

    public function __construct(
        private readonly EquipmentService $equipmentService
    )
    {
    }

    #[OA\Put(
        path: '/api/equipments/{id}',
        summary: 'Update a specific equipment by ID',
        requestBody: new OA\RequestBody(
            description: 'Character update payload',
            required: true,
            content: new OA\JsonContent(
                ref: '#/components/schemas/EquipmentPayload'
            )
        ),
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'ID of the character to update',
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
                description: 'Successful update of the equipment',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'string', example: 'success'),
                        new OA\Property(
                            ref: '#/components/schemas/Equipment'
                        )
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
    public function __invoke(
        Request $request,
        Response $response,
        $args
    ): Response
    {
        try {
            $bodyEncoded = $request->getBody();
            $body = json_decode($bodyEncoded, true);
            $equipment = $this->equipmentService->update($args['id'], $body);
            return ResponseBuilder::success($equipment->toArray());
        } catch (EquipmentNotFoundException $e) {
            return ResponseBuilder::notFound($e->getMessage());
        } catch (\Exception $e) {
            return ResponseBuilder::serverError($e->getMessage());
        }
    }

}