<?php

use App\UI\Http\Controllers\Factions\DeleteFactionController;
use App\Application\Services\FactionsService;
use PHPUnit\Framework\TestCase;
use Slim\Psr7\Factory\ServerRequestFactory;

class DeleteFactionControllerTest extends TestCase
{

    private DeleteFactionController $controller;

    /**
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    protected function setUp(): void
    {
        $factionService = $this->createMock(FactionsService::class);
        $this->controller = new DeleteFactionController(
            $factionService
        );
    }

    function testDeleteFactionPage(): void
    {
        $request = (new ServerRequestFactory())->createServerRequest('DELETE', '/factions/1');
        $response = new \Slim\Psr7\Response();
        $response = ($this->controller)($request, $response, ['id' => 1]);

        $this->assertEquals(200, $response->getStatusCode());
    }
}