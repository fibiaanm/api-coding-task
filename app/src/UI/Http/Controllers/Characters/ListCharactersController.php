<?php

namespace App\UI\Http\Controllers\Characters;

use App\Application\DataObjects\PaginationObject;
use App\Application\Services\CharacterService;
use App\Infrastructure\Exceptions\CharactersNotFoundException;
use App\UI\Http\Responses\ResponseBuilder;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

use OpenApi\Attributes as OA;

class ListCharactersController
{
    public function __construct(
        private readonly CharacterService $characterService
    )
    {
    }

    #[OA\Get(
        path: '/api/characters',
        summary: 'Get a list of characters',
        parameters: [
            new OA\Parameter(ref: '#/components/parameters/PageParameter'),
            new OA\Parameter(ref: '#/components/parameters/LimitParameter')
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successful response with a list of characters',
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
                                    property: 'character',
                                    type: 'array',
                                    items: new OA\Items(
                                        ref: '#/components/schemas/Character'
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
                description: 'Character not found',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'string', example: 'error'),
                        new OA\Property(property: 'message', type: 'string', example: 'Character not found')
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

            $characters = $this->characterService->list($pagination);
            return ResponseBuilder::success([
                'next_page' => $pagination->buildNextPageLink($request),
                'characters' => $characters->toArray()
            ]);
        } catch (CharactersNotFoundException $e) {
            return ResponseBuilder::notFound('Characters not found');
        } catch (\Exception $e) {
            return ResponseBuilder::serverError($e->getMessage());
        }
    }

}