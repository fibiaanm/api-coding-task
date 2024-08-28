<?php

namespace App\UI\Http\Controllers\Api;

use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Response;

class HomeController
{
    public function __invoke(ServerRequestInterface $request, Response $response): Response
    {
        $data = [
            'name' => 'Lotr Api',
            'version' => '1.0'
        ];
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');
    }
}