<?php

namespace App\UI\Http\Controllers\Factions;

class DetailFactionController
{

    public function __invoke($request, $response, $args)
    {
        $data = [
            'name' => 'Detail Faction Controller',
            'id' => $args['id']
        ];

        $response->getBody()->write(json_encode($data, JSON_UNESCAPED_UNICODE));
        return $response->withHeader('Content-Type', 'application/json');
    }
}