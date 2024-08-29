<?php

use App\UI\Http\Controllers\Factions\ListFactionsController;
use App\Application\Services\FactionsService;
use PHPUnit\Framework\TestCase;
use Slim\Psr7\Factory\ServerRequestFactory;

class ListFactionsControllerTest extends TestCase
{

    private ListFactionsController $controller;

    /**
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    protected function setUp(): void
    {
        $factionService = $this->createMock(FactionsService::class);
        $this->controller = new ListFactionsController(
            $factionService
        );
    }

    function testListFactionsPage(): void
    {
        $request = (new ServerRequestFactory())->createServerRequest('GET', '/factions');
        $response = new \Slim\Psr7\Response();
        $response = ($this->controller)($request, $response);

        $this->assertEquals(200, $response->getStatusCode());
    }

}