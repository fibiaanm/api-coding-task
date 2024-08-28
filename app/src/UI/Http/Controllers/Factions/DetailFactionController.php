<?php

namespace App\UI\Http\Controllers\Factions;

use App\Application\Services\Factions\FactionsService;

class DetailFactionController
{
    function __construct(
        private FactionsService $factionsService
    )
    {
    }

    public function __invoke($request, $response, $args)
    {
        $data = $this->factionsService->detail($args['id']);

        $response->getBody()->write(json_encode($data, JSON_UNESCAPED_UNICODE));
        return $response->withHeader('Content-Type', 'application/json');
    }
}