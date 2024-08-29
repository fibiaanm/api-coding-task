<?php

use App\UI\Http\Controllers\Characters\CreateCharacterController;
use App\Application\Services\CharacterService;
use PHPUnit\Framework\TestCase;
use Slim\Psr7\Factory\ServerRequestFactory;
use Slim\Psr7\Response;

class CreateCharacterControllerTest extends TestCase
{

        private CreateCharacterController $controller;

        /**
        * @throws \PHPUnit\Framework\MockObject\Exception
        */
        protected function setUp(): void
        {
            $characterService = $this->createMock(CharacterService::class);
            $this->controller = new CreateCharacterController(
                $characterService
            );
        }

        function testCreateCharacterPage(): void
        {
            $request = (new ServerRequestFactory())->createServerRequest('POST', '/characters');
            $response = new Response();
            $response = ($this->controller)($request, $response);

            $this->assertEquals(200, $response->getStatusCode());
        }

}