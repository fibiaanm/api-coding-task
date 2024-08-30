<?php

namespace Unit;

use App\Application\Services\FactionsService;
use App\UI\Http\Controllers\Factions\CreateFactionController;
use PHPUnit\Framework\TestCase;
use Slim\Psr7\Factory\ServerRequestFactory;


class CreateFactionControllerTest extends TestCase
{

    private CreateFactionController $controller;

    /**
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    protected function setUp(): void
    {
        $factionService = $this->createMock(FactionsService::class);
        $this->controller = new CreateFactionController(
            $factionService
        );
    }

    function testCreateFactionPage(): void
    {
        $request = (new ServerRequestFactory())->createServerRequest('POST', '/factions');
        $response = new \Slim\Psr7\Response();
        $response = ($this->controller)($request, $response);

        $this->assertEquals(201, $response->getStatusCode());
    }

}