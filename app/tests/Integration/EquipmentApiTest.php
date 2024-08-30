<?php

namespace Integration;

use App\TokenHelper;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class EquipmentApiTest extends TestCase
{
    protected $client;
    private string $token = "";
    static int $equipmentId = 0;

    protected function setUp(): void
    {
        $this->client = new Client([
            'base_uri' => 'http://localhost:8080',
            'http_errors' => false,
        ]);
        $this->token = TokenHelper::getToken();
    }

    public function testCreateEquipmentApi(): void
    {
        $response = $this->client->post('/api/equipments', [
            'json' => [
                'name' => 'Equipment Test',
                'type' => 'Type Test',
                'made_by' => 'Made By Test',
            ],
            'headers' => [
                'Authorization' => 'Bearer ' . $this->token
            ]
        ]);
        $this->assertEquals(201, $response->getStatusCode());
        $responseResult = json_decode($response->getBody(), true);
        $this->assertEquals('Equipment Test', $responseResult['data']['name']);
        $this->assertEquals('Type Test', $responseResult['data']['type']);
        $this->assertEquals('Made By Test', $responseResult['data']['madeBy']);
        self::$equipmentId = $responseResult['data']['id'];
    }

    public function testListEquipmentsApi(): void
    {
        $response = $this->client->get('/api/equipments');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testDetailEquipmentApi(): void
    {
        $response = $this->client->get('/api/equipments/' . self::$equipmentId);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testUpdateEquipmentApi(): void
    {
        $response = $this->client->put('/api/equipments/' . self::$equipmentId, [
            'json' => [
                'name' => 'Equipment Test Updated',
                'type' => 'Type Test Updated',
                'made_by' => 'Made By Test Updated',
            ],
            'headers' => [
                'Authorization' => 'Bearer ' . $this->token
            ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $responseResult = json_decode($response->getBody(), true);
        $this->assertEquals('Equipment Test Updated', $responseResult['data']['name']);
        $this->assertEquals('Type Test Updated', $responseResult['data']['type']);
        $this->assertEquals('Made By Test Updated', $responseResult['data']['madeBy']);
    }

    public function testDeleteEquipmentApi(): void
    {
        $response = $this->client->delete('/api/equipments/' . self::$equipmentId, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->token,
            ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testCacheResponseOnDetailDeletedApi()
    {
        $response = $this->client->get('/api/equipments/' . self::$equipmentId);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testCantCreateEquipmentsWithoutToken(): void
    {
        $response = $this->client->post('/api/equipments', [
            'json' => [
                'name' => 'Equipment Test',
                'type' => 'Type Test',
                'made_by' => 'Made By Test',
            ],
        ]);
        $this->assertEquals(401, $response->getStatusCode());
    }

}