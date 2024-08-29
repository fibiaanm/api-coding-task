<?php

namespace App\UI\Http\Middlewares;

use App\Application\Services\UserService;
use App\Infrastructure\Exceptions\UserNotFoundException;
use App\Infrastructure\Exceptions\UserTokenExpired;
use App\Infrastructure\Exceptions\UserTokenInvalidException;
use App\Infrastructure\Exceptions\UserTokenNotProvidedException;
use App\UI\Http\Responses\ResponseBuilder;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class AuthMiddleware
{

    function __construct(
        private UserService $userService
    ) {

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
            $user->token = $token;
            $this->userService->authenticated($user);
            return $handler->handle($request);
        } catch (UserNotFoundException $e) {
            return ResponseBuilder::unauthorized('Unauthorized');
        } catch (UserTokenExpired $e) {
            return ResponseBuilder::unauthorized('Token expired');
        } catch (UserTokenNotProvidedException|UserTokenInvalidException $e) {
            return ResponseBuilder::unauthorized('Token not provided or invalid');
        } catch (\Exception $e) {
            return ResponseBuilder::serverError('Internal server error');
        }
    }
}