<?php

namespace Unit;

use App\Application\Services\EquipmentService;
use App\UI\Http\Controllers\Equipments\DetailEquipmentController;
use PHPUnit\Framework\TestCase;
use Slim\Psr7\Factory\ServerRequestFactory;
use Slim\Psr7\Response;

class DetailEquipmentControllerTest extends TestCase
{

    private DetailEquipmentController $controller;

    /**
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    protected function setUp(): void
    {
        $equipmentService = $this->createMock(EquipmentService::class);
        $this->controller = new DetailEquipmentController(
            $equipmentService
        );
    }

    function testDetailEquipmentPage(): void
    {
        $request = (new ServerRequestFactory())->createServerRequest('GET', '/equipments');
        $response = new Response();
        $response = ($this->controller)($request, $response, ['id' => 1]);

        $this->assertEquals(200, $response->getStatusCode());
    }

}