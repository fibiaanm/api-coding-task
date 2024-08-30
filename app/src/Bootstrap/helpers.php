<?php

use App\Infrastructure\Services\AuthenticatedUserService;
use App\UI\Http\Middlewares\AuthorizationMiddleware;

function user(): AuthenticatedUserService
{
    $container = $GLOBALS['container'];
    return $container->get(AuthenticatedUserService::class);
}

function authorization(array $roles): AuthorizationMiddleware
{
    return new AuthorizationMiddleware($roles);
}