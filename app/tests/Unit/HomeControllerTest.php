<?php

namespace Unit;

use App\UI\Http\Controllers\Api\HomeController;
use PHPUnit\Framework\TestCase;
use Slim\Psr7\Factory\ServerRequestFactory;

class HomeControllerTest extends TestCase
{

    private HomeController $controller;

    protected function setUp(): void
    {
        $this->controller = new HomeController();
    }

    function testHomePage(): void
    {
        $request = (new ServerRequestFactory())->createServerRequest('GET', '/');
        $response = new \Slim\Psr7\Response();
        $response = ($this->controller)($request, $response);

        $this->assertEquals(200, $response->getStatusCode());
    }

}