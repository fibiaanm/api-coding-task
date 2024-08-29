<?php

namespace App\UI\Http\Responses;

use Slim\Psr7\Response;

class ResponseBuilder
{

    static public function success(array $data): Response
    {
        $response = new Response();
        $response->getBody()->write(json_encode([
            'status' => 'success',
            'data' => $data
        ], JSON_UNESCAPED_UNICODE));
        return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
    }

    static public function unauthorized(string $message): Response
    {
        $response = new Response();
        $response->getBody()->write(json_encode([
            'status' => 'error',
            'message' => $message
        ], JSON_UNESCAPED_UNICODE));
        return $response->withStatus(401)->withHeader('Content-Type', 'application/json');
    }

    static public function notFound(string $message): Response
    {
        $response = new Response();
        $response->getBody()->write(json_encode([
            'status' => 'error',
            'message' => $message
        ], JSON_UNESCAPED_UNICODE));
        return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
    }

    static public function serverError(string $message): Response
    {
        $response = new Response();
        $response->getBody()->write(json_encode([
            'status' => 'error',
            'message' => $message
        ], JSON_UNESCAPED_UNICODE));
        return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
    }

}