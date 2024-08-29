<?php

namespace App\UI\Http\Middlewares;

use App\Application\Services\UserService;
use App\Infrastructure\Exceptions\UserNotFoundException;
use App\Infrastructure\Exceptions\UserTokenExpired;
use App\Infrastructure\Exceptions\UserTokenInvalidException;
use App\Infrastructure\Exceptions\UserTokenNotProvidedException;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class AuthMiddleware
{

    function __construct(
        private UserService $userService
    )
    {

    }

    function __invoke(Request $request, $handler): Response
    {
        try {
            $bearerToken = $request->getHeader('Authorization')[0] ?? '';
            if (!$bearerToken) {
                throw new UserTokenNotProvidedException();
            }
            $token = str_replace('Bearer ', '', $bearerToken);
            $user = $this->userService->validateToken($token);
            $request = $request->withAttribute('user', $user);
            return $handler->handle($request);
        } catch (UserNotFoundException $e) {
            $response = new Response();
            $response->getBody()->write(json_encode(['error' => 'Unrecognized token'], JSON_UNESCAPED_UNICODE));
            return $response->withStatus(401)->withHeader('Content-Type', 'application/json');
        } catch (UserTokenExpired $e) {
            $response = new Response();
            $response->getBody()->write(json_encode(['error' => 'Token expired'], JSON_UNESCAPED_UNICODE));
            return $response->withStatus(401)->withHeader('Content-Type', 'application/json');
        } catch (UserTokenNotProvidedException|UserTokenInvalidException $e) {
            $response = new Response();
            $response->getBody()->write(json_encode(['error' => 'Unauthorized'], JSON_UNESCAPED_UNICODE));
            return $response->withStatus(401)->withHeader('Content-Type', 'application/json');
        } catch (\Exception $e) {
            var_dump($e);
            $response = new Response();
            $response->getBody()->write(json_encode(['error' => 'Internal server error in middleware'], JSON_UNESCAPED_UNICODE));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }
}