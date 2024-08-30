<?php

namespace Unit;

use App\Application\Services\EquipmentService;
use App\UI\Http\Controllers\Equipments\CreateEquipmentController;
use PHPUnit\Framework\TestCase;
use Slim\Psr7\Factory\ServerRequestFactory;
use Slim\Psr7\Response;

class CreateEquipmentControllerTest extends TestCase
{

    private CreateEquipmentController $controller;

    /**
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    protected function setUp(): void
    {
        $equipmentService = $this->createMock(EquipmentService::class);
        $this->controller = new CreateEquipmentController(
            $equipmentService
        );
    }

    function testCreateEquipmentPage(): void
    {
        $request = (new ServerRequestFactory())->createServerRequest('POST', '/equipments');
        $response = new Response();
        $response = ($this->controller)($request, $response);

        $this->assertEquals(201, $response->getStatusCode());
    }

}