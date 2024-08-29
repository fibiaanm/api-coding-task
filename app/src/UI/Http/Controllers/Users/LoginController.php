<?php

namespace App\UI\Http\Controllers\Users;

use App\Application\Exceptions\InvalidUserPasswordException;
use App\Application\Services\UserService;
use App\Infrastructure\Exceptions\UserNotFoundException;
use App\Infrastructure\Exceptions\UserTokenCannotCreateException;
use App\UI\Http\Responses\ResponseBuilder;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

use OpenApi\Attributes as OA;

class LoginController
{
    function __construct(
        private UserService $userService
    ) {
    }

    #[OA\Post(
        path: '/auth/login',
        summary: 'User login endpoint',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'admin'),
                    new OA\Property(property: 'password', type: 'string', example: '1f3d38abc5b698ad3c95341edefeb469'),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successful login',
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
                                    property: 'user',
                                    properties: [
                                        new OA\Property(property: 'id', type: 'integer', example: 1),
                                        new OA\Property(property: 'name', type: 'string', example: 'admin'),
                                        new OA\Property(property: 'token', type: 'string', example: 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...'),
                                        new OA\Property(
                                            property: 'roles',
                                            type: 'array',
                                            items: new OA\Items(type: 'string', example: 'admin')
                                        ),
                                    ],
                                    type: 'object'
                                )
                            ],
                            type: 'object'
                        )
                    ]
                )
            ),
            new OA\Response(
                response: 401,
                description: 'Unauthorized: Invalid credentials',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'string', example: 'error'),
                        new OA\Property(property: 'message', type: 'string', example: 'Invalid credentials')
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Not Found: User not found',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'string', example: 'error'),
                        new OA\Property(property: 'message', type: 'string', example: 'User not found')
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
    function __invoke(Request $request, Response $response): Response
    {
        try {
            $dataEncoded = $request->getBody();
            $data = json_decode($dataEncoded, true);

            $user = $this->userService->login($data['name'], $data['password']);

            return ResponseBuilder::success(
                [
                'user' => $user->toArray()
                ]
            );
        } catch (UserNotFoundException $e) {
            return ResponseBuilder::notFound("User not found");
        } catch (InvalidUserPasswordException|UserTokenCannotCreateException $e) {
            return ResponseBuilder::unauthorized("Invalid password");
        }
    }
}