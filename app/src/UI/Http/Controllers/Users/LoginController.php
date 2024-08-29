<?php

namespace App\UI\Http\Controllers\Users;

use App\Application\Exceptions\InvalidUserPasswordException;
use App\Application\Services\UserService;
use App\Infrastructure\Exceptions\UserNotFoundException;
use App\Infrastructure\Exceptions\UserTokenCannotCreateException;
use App\UI\Http\Responses\ResponseBuilder;
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

            return ResponseBuilder::success([
                'user' => $user->toArray()
            ]);
        } catch (UserNotFoundException $e) {
            return ResponseBuilder::unauthorized("User not found");
        } catch (InvalidUserPasswordException|UserTokenCannotCreateException $e) {
            return ResponseBuilder::unauthorized("Invalid password");
        }
    }
}