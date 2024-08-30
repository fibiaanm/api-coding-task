<?php

namespace App\UI\Http\Controllers\Equipments;


use App\Application\DataObjects\PaginationObject;
use App\Application\Services\EquipmentService;
use App\Infrastructure\Exceptions\EquipmentsNotFoundException;
use App\UI\Http\Responses\ResponseBuilder;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use OpenApi\Attributes as OA;

class ListEquipmentController
{
    public function __construct(
        private readonly EquipmentService $equipmentService
    )
    {
    }

    #[OA\Get(
        path: '/api/equipments',
        summary: 'Get a list of equipments',
        parameters: [
            new OA\Parameter(ref: '#/components/parameters/PageParameter'),
            new OA\Parameter(ref: '#/components/parameters/LimitParameter')
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successful response with a list of equipments',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'status',
                            type: 'string',
                            example: 'success'
                        ),
                        new OA\Property(
                            property: 'data',
                            properties: [
                                new OA\Property(
                                    property: 'next_page',
                                    type: 'string',
                                    example: ''
                                ),
                                new OA\Property(
                                    property: 'equipment',
                                    type: 'array',
                                    items: new OA\Items(
                                        ref: '#/components/schemas/Equipment'
                                    )
                                )
                            ],
                            type: 'object'
                        )
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Equipment not found',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'string', example: 'error'),
                        new OA\Property(property: 'message', type: 'string', example: 'Equipment not found')
                    ]
                )
            ),
            new OA\Response(
                response: 422,
                description: 'Validation errors on query parameters',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'string', example: 'error'),
                        new OA\Property(property: 'message', type: 'string', example: 'Field limit is invalid')
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
    public function __invoke(
        Request $request,
        Response $response,
    ): Response
    {
        try {
            $page = $request->getQueryParams()['page'] ?? 1;
            $limit = $request->getQueryParams()['limit'] ?? 10;
            $pagination = new PaginationObject($page, $limit);
            $equipments = $this->equipmentService->list($pagination);
            return ResponseBuilder::success([
                'next_page' => $pagination->buildNextPageLink($request),
                'equipment' => $equipments->toArray()
            ]);
        } catch (EquipmentsNotFoundException $e) {
            return ResponseBuilder::notFound($e->getMessage());
        } catch (\Exception $e) {
            return ResponseBuilder::serverError($e->getMessage());
        }
    }

}