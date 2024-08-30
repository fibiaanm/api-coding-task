<?php

namespace Unit;

use App\Application\Services\CharacterService;
use App\UI\Http\Controllers\Characters\ListCharactersController;
use PHPUnit\Framework\TestCase;
use Slim\Psr7\Factory\ServerRequestFactory;
use Slim\Psr7\Response;

class ListCharacterControllerTest extends TestCase
{

    private ListCharactersController $controller;

    /**
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    protected function setUp(): void
    {
        $characterService = $this->createMock(CharacterService::class);
        $this->controller = new ListCharactersController(
            $characterService
        );
    }

    function testListCharacterPage(): void
    {
        $request = (new ServerRequestFactory())->createServerRequest('GET', '/characters');
        $response = new Response();
        $response = ($this->controller)($request, $response);

        $this->assertEquals(200, $response->getStatusCode());
    }

}

{

}