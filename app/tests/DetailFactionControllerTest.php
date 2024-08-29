<?php

use App\UI\Http\Controllers\Factions\DetailFactionController;
use App\Application\Services\FactionsService;
use PHPUnit\Framework\TestCase;
use Slim\Psr7\Factory\ServerRequestFactory;

class DetailFactionControllerTest extends TestCase
{

    private DetailFactionController $controller;

    /**
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    protected function setUp(): void
    {
        $factionService = $this->createMock(FactionsService::class);
        $this->controller = new DetailFactionController(
            $factionService
        );
    }

    function testDetailFactionPage(): void
    {
        $request = (new ServerRequestFactory())->createServerRequest('GET', '/factions/1');
        $response = new \Slim\Psr7\Response();
        $response = ($this->controller)($request, $response, ['id' => 1]);

        $this->assertEquals(200, $response->getStatusCode());
    }
}