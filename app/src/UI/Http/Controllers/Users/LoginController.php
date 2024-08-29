<?php

namespace App\UI\Http\Controllers\Users;

use App\Application\Exceptions\InvalidUserPasswordException;
use App\Application\Services\UserService;
use App\Infrastructure\Exceptions\UserNotFoundException;
use App\Infrastructure\Exceptions\UserTokenCannotCreateException;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class LoginController
{
    function __construct(
        private UserService $userService
    ){
    }

    function __invoke(Request $request, Response $response): Response
    {
        try {
            $dataEncoded = $request->getBody();
            $data = json_decode($dataEncoded, true);

            $user = $this->userService->login($data['name'], $data['password']);

            $response->getBody()->write(json_encode([
                'user' => $user->toArray()
            ], JSON_UNESCAPED_UNICODE));
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (UserNotFoundException $e) {
            $response->getBody()->write(json_encode(['error' => 'User not found'], JSON_UNESCAPED_UNICODE));
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        } catch (InvalidUserPasswordException|UserTokenCannotCreateException $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()], JSON_UNESCAPED_UNICODE));
            return $response->withStatus(401)->withHeader('Content-Type', 'application/json');
        }
    }
}