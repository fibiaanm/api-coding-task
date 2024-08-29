<?php

namespace App\UI\Http\Controllers\Api;

use Slim\Psr7\Response;

class DocumentationController
{
    public function __invoke(): Response
    {
        include __DIR__ . '/../../Views/doc/documentation.php';
        return new Response(200);
    }
}