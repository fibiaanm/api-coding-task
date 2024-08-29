<?php

use App\UI\Http\Controllers\Characters\DetailCharacterController;
use App\Application\Services\CharacterService;
use PHPUnit\Framework\TestCase;
use Slim\Psr7\Factory\ServerRequestFactory;
use Slim\Psr7\Response;

class DetailCharacterControllerTest extends TestCase
{

    private DetailCharacterController $controller;

    /**
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    protected function setUp(): void
    {
        $characterService = $this->createMock(CharacterService::class);
        $this->controller = new DetailCharacterController(
            $characterService
        );
    }

    function testDetailCharacterPage(): void
    {
        $request = (new ServerRequestFactory())->createServerRequest('GET', '/characters/1');
        $response = new Response();
        $response = ($this->controller)($request, $response, ['id' => 1]);

        $this->assertEquals(200, $response->getStatusCode());
    }

}
{

}