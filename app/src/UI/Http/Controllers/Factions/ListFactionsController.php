<?php

namespace App\UI\Http\Controllers\Factions;

use App\Application\DataObjects\PaginationObject;
use App\Application\Services\FactionsService;
use App\Infrastructure\Exceptions\FactionsNotFoundException;
use App\UI\Http\Responses\ResponseBuilder;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

use OpenApi\Attributes as OA;

class ListFactionsController
{

    function __construct(
        private readonly FactionsService $factionsService
    )
    {

    }

    #[OA\Get(
        path: '/api/factions',
        summary: 'Get a list of factions',
        parameters: [
            new OA\Parameter(ref: '#/components/parameters/PageParameter'),
            new OA\Parameter(ref: '#/components/parameters/LimitParameter')
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successful response with a list of factions',
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
                                    property: 'factions',
                                    type: 'array',
                                    items: new OA\Items(
                                        ref: '#/components/schemas/Factions'
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
                description: 'Factions not found',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'string', example: 'error'),
                        new OA\Property(property: 'message', type: 'string', example: 'Factions not found')
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
    public function __invoke(Request $request, Response $response): Response
    {
        try {
            $page = $request->getQueryParams()['page'] ?? 1;
            $limit = $request->getQueryParams()['limit'] ?? 10;
            $pagination = new PaginationObject($page, $limit);

            $factions = $this->factionsService->list($pagination);

            // Return the response with factions and next page link
            return ResponseBuilder::success([
                'next_page' => $pagination->buildNextPageLink($request),
                'factions' => $factions->toArray(),
            ]);
        } catch (FactionsNotFoundException $e) {
            return ResponseBuilder::notFound('Factions not found');
        } catch (\Exception $e) {
            return ResponseBuilder::serverError('Internal server error');
        }
    }

}