<?php

namespace Unit;

use App\Application\Services\FactionsService;
use App\UI\Http\Controllers\Factions\UpdateFactionController;
use PHPUnit\Framework\TestCase;
use Slim\Psr7\Factory\ServerRequestFactory;

class UpdateFactionControllerTest extends TestCase
{

    private UpdateFactionController $controller;

    /**
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    protected function setUp(): void
    {
        $factionService = $this->createMock(FactionsService::class);
        $this->controller = new UpdateFactionController(
            $factionService
        );
    }

    function testUpdateFactionPage(): void
    {
        $request = (new ServerRequestFactory())->createServerRequest('PUT', '/factions/1');
        $response = new \Slim\Psr7\Response();
        $response = ($this->controller)($request, $response, ['id' => 1]);

        $this->assertEquals(200, $response->getStatusCode());
    }

}