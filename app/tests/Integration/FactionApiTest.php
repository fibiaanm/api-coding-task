<?php

namespace Integration;

use App\TokenHelper;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;


class FactionApiTest extends TestCase
{

    protected $client;
    private string $token = "";
    static int $factionId = 0;

    protected function setUp(): void
    {
        $this->client = new Client([
            'base_uri' => 'http://localhost:8080',
            'http_errors' => false,
        ]);
        $this->token = TokenHelper::getToken();
    }

    public function testCreateFactionsApi(): void
    {
        $response = $this->client->post('/api/factions', [
            'json' => [
                'name' => 'Faction Test',
                'description' => 'Description Test',
            ],
            'headers' => [
                'Authorization' => 'Bearer ' . $this->token
            ]
        ]);
        $this->assertEquals(201, $response->getStatusCode());
        $responseResult = json_decode($response->getBody(), true);
        $this->assertEquals('Faction Test', $responseResult['data']['name']);
        $this->assertEquals('Description Test', $responseResult['data']['description']);
        self::$factionId = $responseResult['data']['id'];
    }

    public function testListFactionsApi(): void
    {
        $response = $this->client->get('/api/factions');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testDetailFactionApi(): void
    {
        $response = $this->client->get('/api/factions/' . self::$factionId);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testUpdateFactionApi(): void
    {
        $response = $this->client->put('/api/factions/' . self::$factionId, [
            'json' => [
                'name' => 'Faction Test Updated',
                'description' => 'Description Test Updated',
            ],
            'headers' => [
                'Authorization' => 'Bearer ' . $this->token
            ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $responseResult = json_decode($response->getBody(), true);
        $this->assertEquals('Faction Test Updated', $responseResult['data']['name']);
        $this->assertEquals('Description Test Updated', $responseResult['data']['description']);

    }

    public function testDeleteFactionApi(): void
    {
        $response = $this->client->delete('/api/factions/' . self::$factionId, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->token,
            ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());

    }

    public function testCacheResponseOnDetailDeletedApi()
    {
        $response = $this->client->get('/api/factions/' . self::$factionId);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testCantCreateFactionsApiWithoutToken(): void
    {
        $response = $this->client->post('/api/factions', [
            'json' => [
                'name' => 'Faction Test',
                'description' => 'Description Test',
            ],
        ]);
        $this->assertEquals(401, $response->getStatusCode());
    }

}