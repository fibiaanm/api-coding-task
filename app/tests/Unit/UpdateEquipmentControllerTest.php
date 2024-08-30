<?php

namespace Unit;

use App\Application\Services\EquipmentService;
use App\UI\Http\Controllers\Equipments\UpdateEquipmentController;
use PHPUnit\Framework\TestCase;
use Slim\Psr7\Factory\ServerRequestFactory;
use Slim\Psr7\Response;

class UpdateEquipmentControllerTest extends TestCase
{

    private UpdateEquipmentController $controller;

    /**
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    protected function setUp(): void
    {
        $equipmentService = $this->createMock(EquipmentService::class);
        $this->controller = new UpdateEquipmentController(
            $equipmentService
        );
    }

    function testUpdateEquipmentPage(): void
    {
        $request = (new ServerRequestFactory())->createServerRequest('POST', '/equipments');
        $response = new Response();
        $response = ($this->controller)($request, $response, ['id' => 1]);

        $this->assertEquals(200, $response->getStatusCode());
    }

}
