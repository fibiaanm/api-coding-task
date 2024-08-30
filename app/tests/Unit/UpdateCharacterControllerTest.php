<?php

namespace Unit;

use App\Application\Services\CharacterService;
use App\UI\Http\Controllers\Characters\UpdateCharacterController;
use PHPUnit\Framework\TestCase;
use Slim\Psr7\Factory\ServerRequestFactory;
use Slim\Psr7\Response;

class UpdateCharacterControllerTest extends TestCase
{

    private UpdateCharacterController $controller;

    /**
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    protected function setUp(): void
    {
        $characterService = $this->createMock(CharacterService::class);
        $this->controller = new UpdateCharacterController(
            $characterService
        );
    }

    function testUpdateCharacterPage(): void
    {
        $request = (new ServerRequestFactory())->createServerRequest('POST', '/characters');
        $response = new Response();
        $response = ($this->controller)($request, $response, ['id' => 1]);

        $this->assertEquals(200, $response->getStatusCode());
    }

}

{

}