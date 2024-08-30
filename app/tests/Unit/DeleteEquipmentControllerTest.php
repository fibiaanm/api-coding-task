<?php

namespace Unit;

use App\Application\Services\EquipmentService;
use App\UI\Http\Controllers\Equipments\DeleteEquipmentController;
use PHPUnit\Framework\TestCase;
use Slim\Psr7\Factory\ServerRequestFactory;
use Slim\Psr7\Response;

class DeleteEquipmentControllerTest extends TestCase
{

    private DeleteEquipmentController $controller;

    /**
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    protected function setUp(): void
    {
        $equipmentService = $this->createMock(EquipmentService::class);
        $this->controller = new DeleteEquipmentController(
            $equipmentService
        );
    }

    function testDeleteEquipmentPage(): void
    {
        $request = (new ServerRequestFactory())->createServerRequest('POST', '/equipments');
        $response = new Response();
        $response = ($this->controller)($request, $response, ['id' => 1]);

        $this->assertEquals(200, $response->getStatusCode());
    }

}