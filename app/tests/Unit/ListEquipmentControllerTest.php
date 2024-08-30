<?php

namespace Unit;

use App\Application\Services\EquipmentService;
use App\UI\Http\Controllers\Equipments\ListEquipmentController;
use PHPUnit\Framework\TestCase;
use Slim\Psr7\Factory\ServerRequestFactory;
use Slim\Psr7\Response;

class ListEquipmentControllerTest extends TestCase
{

    private ListEquipmentController $controller;

    /**
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    protected function setUp(): void
    {
        $equipmentService = $this->createMock(EquipmentService::class);
        $this->controller = new ListEquipmentController(
            $equipmentService
        );
    }

    function testListEquipmentPage(): void
    {
        $request = (new ServerRequestFactory())->createServerRequest('GET', '/equipments');
        $response = new Response();
        $response = ($this->controller)($request, $response);

        $this->assertEquals(200, $response->getStatusCode());
    }

}