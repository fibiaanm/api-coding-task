<?php

namespace App\UI\Http\Controllers\Factions;

class CreateFactionController
{
    public function __invoke($request, $response, $args)
    {
        $data = [
            'name' => 'Create Faction Controller',
            'id' => $args['id']
        ];

        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');
    }

}