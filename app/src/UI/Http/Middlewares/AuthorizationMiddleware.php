<?php

namespace App\UI\Http\Middlewares;

use App\UI\Http\Responses\ResponseBuilder;

class AuthorizationMiddleware
{

    public function __construct(
        private array $roles
    )
    {
    }

    public function __invoke($request, $handler)
    {
        $user = user()->get();
        $userRoles = $user->roles;
        $intersect = array_intersect($this->roles, $userRoles);
        if (empty($intersect)) {
            return ResponseBuilder::forbidden('Forbidden');
        }
        // Go to next middleware
        return $handler->handle($request);
    }

}