<?php

namespace App\UI\Http\Controllers\Factions;

use App\Application\Services\Factions\FactionsService;

class CreateFactionController
{

    function __construct(
        private FactionsService $factionsService
    )
    {

    }

    public function __invoke($request, $response, $args)
    {
        $data = [
            'faction_name' => 'Faction Name',
            'description' => 'Descripción de la facción en español',
        ];

        $faction = $this->factionsService->create($data);

        $response->getBody()->write(json_encode($faction->toArray()), JSON_UNESCAPED_UNICODE);
        return $response->withHeader('Content-Type', 'application/json');
    }

}