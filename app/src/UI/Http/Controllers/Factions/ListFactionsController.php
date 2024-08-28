<?php

namespace App\UI\Http\Controllers\Factions;

use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Psr7\Response;

class ListFactionsController
{

    function __construct(
        private \PDO $db
    )
    {

    }

    public function __invoke(Request $request, Response $response): Response
    {
        $statement =$this->db->query('SELECT * FROM factions');
        $factions = $statement->fetchAll();
        $dat = json_encode($factions, JSON_UNESCAPED_UNICODE);

        error_log($dat);

        $response->getBody()->write($dat);
        return $response->withHeader('Content-Type', 'application/json; charset=utf-8');

    }

}